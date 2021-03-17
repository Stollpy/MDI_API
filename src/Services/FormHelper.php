<?php

namespace App\Services;

use DateTime;
use LogicException;
use App\Entity\ProfilModelData;
use App\Repository\UserRepository;
use App\Repository\IndividualDataRepository;
use Symfony\Component\Security\Core\Security;

class FormHelper {
    
    private $userRepository;
    private $security;
    private $user;
    private $dataRepository;

    /**
     * Constructor
     *
     * @param UserRepository $userRepository
     * @param Security $security
     * @param IndividualDataRepository $dataRepository
     */
    public function __construct(UserRepository $userRepository, Security $security, IndividualDataRepository $dataRepository)
    {
        $this->security = $security;
        $this->userRepository = $userRepository;
        $this->user = $this->userRepository->find($this->security->getUser());
        $this->dataRepository = $dataRepository;
    }

    /**
     * Retournes les données nécessaires 
     * pour générer un formulaire 
     *  
     * @param array $models
     * @return void
     */
    public function dataForm($models)
    {
        $datas = [];

        foreach ($models as $model){
            $data = $this->genericData($model);
            array_push($datas, $data);
        }
        return $datas;
    }

    /**
     * Traitement des données reçu pour
     * construire le formulaire
     *
     * @param ProfilModelData $model
     * @return array
     */
    public function genericData(ProfilModelData $model)
    {
        $types = $this->typeIdentity();
        $data = $this->dataRepository->getDataByCode($this->user->getIndividual(), $model->getCode());
        $dataForm = [];

        $dataForm['code'] = $model->getCode();
        $dataForm['label'] = $model->getLabel();
        // Ajoute le type de form
        if(array_key_exists($model->getType(), $types)){
            $dataForm['type'] = $types[$model->getType()];
        }else{
            throw new LogicException('Invalid type !');
        }
        // Transforme les données reçu        
        $dataForm['data']['data'] = $this->dataFormats($model->getType(), $data->getData());
        $dataForm['data']['id'] = $data->getId();

        return $dataForm;
    }

    /**
     * Formate si besoins les données 
     * à pré-remplire
     *
     * @param string $code
     * @param string $data
     * @return void
     */
    public function dataFormats(string $code, string $data)
    {
        // Pour tel  06 à +33 ^^
        if($code == 'date'){
            return DateTime::createFromFormat('Y-m-d', $data);
        }elseif($code == 'tel' || $code == 'number' || $code == 'country'){
            return intval($data);
        }elseif($code == 'text'){
            return $data;
        }
    }

    /**
     * Type de formulaire avec 
     * namespace
     *
     * @return array
     */
    public function typeIdentity()
    {
        $types = [
            "text" => 'Symfony\Component\Form\Extension\Core\Type\TextType',
            "date" => 'Symfony\Component\Form\Extension\Core\Type\DateType',
            "tel" => 'Symfony\Component\Form\Extension\Core\Type\TelType',
            'number' => 'Symfony\Component\Form\Extension\Core\Type\NumberType',
            'country' => 'Symfony\Component\Form\Extension\Core\Type\CountryType',
        ];

        return $types;
    }
}