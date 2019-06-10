<?php



if( !class_exists ( 'NCM_DB_Checkout' ) ) {







class NCM_DB_Checkout{







    function __construct(){



    



    }







    function ncm_checkout_user_fields( $ncm_fields = array() ) {



        



        $ncm_fields[] = array(



            "label" => __("First Name", NCM_txt_domain),



            "required" => "1",



            "type" => "text",



        );







        $ncm_fields[] = array(



            "label" => __("Last Name", NCM_txt_domain),



            "required" => "1",



            "type" => "text",



        );







        $ncm_fields[] = array(



            "label" => __("Email", NCM_txt_domain),



            "required" => "1",



            "type" => "text",



        );







        $ncm_fields[] = array(



            "label" => __('Phone/Mobile', NCM_txt_domain),



            "required" => "1",



            "type" => "text",



        );







        $ncm_fields[] = array(



            "label" => __('Country', NCM_txt_domain),



            "required" => "1",



            "type" => "select",



            "list" => $this->ncm_get_countries_state(),



        );



        



        return $ncm_fields;



    }







    function ncm_get_subtotal() {



        return array(



                    'type' => 'text',



                    'name' => 'ncm_subtotal',



                    'id' => 'ncm_subtotal',



                    'readonly' => 'readonly',



                    'class' => 'form-control',



                    'value' => '0.00'



                );



    }







    function ncm_get_total(){



        return array(



                    'type' => 'text',



                    'name' => 'ncm_total',



                    'id' => 'ncm_total',



                    'readonly' => 'readonly',



                    'class' => 'form-control',



                    'value' => '0.00'



                );



    }







}



}



