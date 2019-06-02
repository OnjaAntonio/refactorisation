<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employe extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->model('Employe_m');

    }

    public function index()
    {
        $this->load->view('layouts/Admin_header');
        $this->load->view('admin/home');
        $this->load->view('layouts/Admin_footer');
    }
//fonction pour ajouter un membre
    public function addMember(){

        $validator = array('success'=> false, 'messages' => array());

        $config = array(
            array(
                'field' => 'name',
                'label' => 'Nom',
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'firstname',
                'label' => 'Prénom',
                'rules' => 'trim|required'
            ),
             array(
                'field' => 'post',
                'label' => 'Poste',
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'nom_util',
                'label' => 'Nom d\'utilisateur',
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'mot_passe',
                'label' => 'Mot de passe',
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'level',
                'label' => 'Level',
                'rules' => 'trim|required'
            ),
        );

        $this->form_validation->set_rules($config);
        $this->form_validation->set_error_delimiters('<p class="text-danger" >','</p>');

        if($this->form_validation->run() === true){

            $addMember = $this->Employe_m->create();
            if ($addMember === true){
                $validator['success'] = true;
                $validator['messages'] = "Employé ajouté avec succès";
            }else{
                $validator['success'] = false;
                $validator['messages'] = "Erreur lors de l'ajout du nouveau employé";
            }
        }else{
            $validator['success'] = false;
            foreach ($_POST as $key => $value){
                $validator['messages'][$key] = form_error($key);
            }

        }

        echo json_encode($validator);
    }


   public function displayData(){
        $result = array('data' => array());


        $data = $this->Employe_m->displayData();
        foreach ($data as $key => $value){

             $btnEdit ='<button
                class="btn btn-default"
                 data-toggle="modal" data-target="#editMemberModal"
                style="border-color: transparent"
                onClick="__editMember('.$value['im_employe'].')"
            ><i class="glyphicon glyphicon-edit" style="color: deepskyblue"></i>    
            </button>';
            $btnRemove ='<button
                class="btn btn-default"
                 data-toggle="modal" data-target="#removeMemberModal"
                style="border-color: transparent"
                  onClick="removeMember('.$value['im_employe'].')"
            ><i class="glyphicon glyphicon-remove" style="color: firebrick"></i>    
            </button>';

              $result['data'][$key] = array(
                $value['im_employe'],
                $value['nom_employe'],
                $value['prenom_employe'],
                $value['poste_employe'],
                $value['util_employe'],
                $value['util_passe'],
                $value['level_employe'],
                $btnEdit,
                $btnRemove
            );
        }
        echo json_encode($result);
    }


    public function getSelectedMemberInfo($id){
        if($id){
            $data = $this->Employe_m->displayData($id);
            echo json_encode($data);
        }
    }

    public function editMember($id = null){
        if($id){
            $validator = array('success'=> false, 'messages' => array());

            $config = array(
                array(
                    'field' => 'edit_name',
                    'label' => 'Nom',
                    'rules' => 'trim|required'
                ),
                array(
                    'field' => 'edit_firstname',
                    'label' => 'Prénom',
                    'rules' => 'trim|required'
                ),
                array(
                    'field' => 'edit_post',
                    'label' => 'Poste',
                    'rules' => 'trim|required'
                ),
                array(
                    'field' => 'edit_nom',
                    'label' => 'Nom d\'utilisateur',
                    'rules' => 'trim|required'
                ),
                array(
                    'field' => 'edit_passe',
                    'label' => 'Mot de passe',
                    'rules' => 'trim|required'
                ),
                array(
                    'field' => 'edit_level',
                    'label' => 'Level',
                    'rules' => 'trim|required'
                ),
            );

            $this->form_validation->set_rules($config);
            $this->form_validation->set_error_delimiters('<p class="text-danger" >','</p>');

            if($this->form_validation->run() === true){

                $editMember = $this->Employe_m->edit($id);
                if ($editMember === true){
                    $validator['success'] = true;
                    $validator['messages'] = "Mis a jour reussi avec succès";
                }else{
                    $validator['success'] = false;
                    $validator['messages'] = "Erreur lors de la mis a jour de l'employé";
                }
            }else{
                $validator['success'] = false;
                foreach ($_POST as $key => $value){
                    $validator['messages'][$key] = form_error($key);
                }

            }

            echo json_encode($validator);
        }
    }

    public function remove($im_employe = null)
    {
        if ($im_employe) {
            $validator = array('success' => false, 'messages' => array());

            $removeMember = $this->Employe_m->remove($im_employe);
            if ($removeMember === true) {
                $validator['success'] = true;
                $validator['messages'] = "Supprimé avec succès";
            }
            else{
                $validator['success'] = true;
                $validator['messages'] = "Supprimé avec succès";
            }

            echo json_encode($validator);
        }
    }

}
