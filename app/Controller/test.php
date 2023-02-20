<?php
class importation_xml {
    public function slugify($text)
    {
        // replace non letter or digits by -
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);
        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);
        // trim
        $text = trim($text, '-');
        // remove duplicate -
        $text = preg_replace('~-+~', '-', $text);
        // lowercase
        $text = strtolower($text);
        if (empty($text))
        {
            return '';
        }
        return $text;
    }

    public function get_category_name_by_code($famille_code)
    {

        global $wpdb;
        $cat_id = $wpdb->get_var( $wpdb->prepare( "SELECT term_id FROM $wpdb->termmeta WHERE meta_key='code' AND meta_value='%s' LIMIT 1", $famille_code ) );

        $famille_name =  $wpdb->get_var( $wpdb->prepare( "SELECT name FROM $wpdb->terms WHERE  term_id='%s' LIMIT 1", $cat_id ) );

        return $famille_name;
    }

    public function ifImageExiste($urlimage)
    {
        $a=false;
        if (file_exists($urlimage))
        {
            $a=true;
        }
        else
        {
            $a=false;
        }
        return $a;
    }

    public function insert_categories()
    {
        $xml=simplexml_load_file("VM/IntelliX/VM/Families.xml");
        $arr = json_decode( json_encode($xml) , 1);

        $familles=$arr['Famille'];
        $nbFamilles = count($arr["Famille"]);


        if(count($arr) ==1 && $arr["Famille"][0] == NULL){
            $familles = $arr;
        }
        /***
         **
         *
        JE PARCOURE LA PREMIERE FOIS POUR AJOUTER LES PARENTS
         *
         **
         ***/

        foreach($familles as $famille)
        {


            if (!empty($famille['CodeParent']))
            {
                /*rien à faire */
            }
            else
            {
                $code_cat=$famille['Code'];
                global $wpdb;
                $cat_id = $wpdb->get_var( $wpdb->prepare( "SELECT term_id FROM $wpdb->termmeta WHERE meta_key='code' AND meta_value='%s' LIMIT 1", $code_cat ));
                /***
                 **
                 *
                SI LA CATEGORY EXISTE JE LA MODIFIE
                 *
                 **
                 ***/
                if($cat_id!=null)
                {
                    if($famille['Famille']!='.'){
                        $slug_cat=$this->slugify($famille['Famille']);
                        wp_update_term($cat_id,'product_cat',array('name'=> $famille['Famille'],'description'=> '','slug' => $slug_cat,'parent' => null));
                    }
                }
                /***
                 **
                 *
                SI LA CATEGORY N EXISTE PAS JE L AJOUTE
                 *
                 **
                 ***/
                else
                {

                    if($famille['Famille']!='.'){

                        $slug_cat=$this->slugify($famille['Famille']);
                        $category=wp_insert_term($famille['Famille'],'product_cat',array('description'=> '','slug' => $slug_cat));
                        if ( !is_wp_error($category) ) {
                            $term_id=$category['term_id'];
                            $term=add_term_meta($term_id, 'code', $code_cat);
                        }
                    }



                }
                error_log( "Traitement de la famille Code : ".$code_cat." Slug : ".$slug_cat." effectué avec succés");
            }
        }

    }

    function insert_sous_categories(){

        /***
         **
         *
        JE PARCOURE LA DEUXIEME FOIS POUR AJOUTER LES FILS
         *
         **
         ***/
        $i=0;
        $xml=simplexml_load_file("VM/IntelliX/VM/Families.xml");
        $arr = json_decode( json_encode($xml) , 1);
        $familles=$arr['Famille'];
        $nbFamilles = count($arr["Famille"]);
        if(count($arr) ==1 && $arr["Famille"][0] == NULL){
            $familles = $arr;
        }
        foreach($familles as $famille)
        {
            $i++;
            if (!empty($famille['CodeParent']))
            {
                $code_cat=$famille['Code'];
                global $wpdb;
                $cat_id = $wpdb->get_var( $wpdb->prepare( "SELECT term_id FROM $wpdb->termmeta WHERE meta_key='code' AND meta_value='%s' LIMIT 1", $code_cat ));

                /***
                 **
                 *
                SI LA CATEGORY EXISTE JE LA MODIFIE
                 *
                 **
                 ***/

                if($cat_id!=null)
                {
                    $CodeParent=$famille['CodeParent'];
                    $cat_parent_id = $wpdb->get_var( $wpdb->prepare( "SELECT term_id FROM $wpdb->termmeta WHERE meta_key='code' AND meta_value='%s' LIMIT 1", $CodeParent ));
                    if($famille['Famille']!='.'){
                        $slug_cat=$this->slugify($famille['Famille']);
                        $cat_id = $wpdb->get_var( $wpdb->prepare( "SELECT term_id FROM $wpdb->termmeta WHERE meta_key='code' AND meta_value='%s' LIMIT 1", $famille['Code'] ) );
                        wp_update_term($cat_id,'product_cat',array('name'=> $famille['Famille'],'description'=> '','slug' => $slug_cat,'parent' => $cat_parent_id ));
                    }
                }
                else
                {
                    $CodeParent=$famille['CodeParent'];
                    $cat_parent_id = $wpdb->get_var( $wpdb->prepare( "SELECT term_id FROM $wpdb->termmeta WHERE meta_key='code' AND meta_value='%s' LIMIT 1", $CodeParent ));
                    if($famille['Famille']!='.'){
                        $slug_cat=$this->slugify($famille['Famille']);
                        $category=wp_insert_term($famille['Famille'],'product_cat',array('description'=> '','slug' => $slug_cat,'parent' => $cat_parent_id));
                        if (!is_wp_error($category) ) {
                            $term_id=$category['term_id'];
                            $term=add_term_meta ($term_id, 'code', $code_cat);
                        }
                    }

                }
                error_log( "Traitement de la famille Code : ".$code_cat." Slug : ".$slug_cat." effectué avec succés");
            }

        }



    }

    function insert_products($produits)
    {

        wp_defer_term_counting(false);
        wp_defer_comment_counting(true);
        $i = 1;

        foreach($produits as $produit)
        {

            //$imageO="";
            $product_sku = (string)$produit['Code'];

            global $wpdb;
            $product_id = $wpdb->get_var( $wpdb->prepare( "SELECT post_id FROM $wpdb->postmeta WHERE meta_key='_sku' AND meta_value='%s' LIMIT 1", $product_sku ) );
            $last_modified_time = $wpdb->get_var( $wpdb->prepare( "SELECT meta_value FROM $wpdb->postmeta WHERE meta_key='_last_modified_time' AND post_id='%s' LIMIT 1", $product_id ) );

            var_dump($last_modified_time);
            if(($product_id!= null) && (!empty($produit['LastModifiedDate']))){
                if(($last_modified_time != $produit['LastModifiedDate'] ))
                {
                    var_dump($product_sku);
                    $title = (string)$produit['Designation'];
                    @$Quantite = (int)$produit['Quantite'];
                    @$category_code = (string)$produit['Famille'];
                    @$Marque = (int)$produit['Marque'];
                    @$toPubly = $produit['ToPubly'];

                    $name_category=(string)$this->get_category_name_by_code($category_code);

                    /*$term = get_term_by( 'name', $name_category, 'product_cat' );
                    $categoryId = $term->term_id;

                    $parentcats = get_ancestors($categoryId, 'product_cat');
                    if(!empty($parentcats)){
                        $parentId = $parentcats[0];
                        $term = get_term_by( 'id', $parentId, 'product_cat' );
                        $name_category = $term->name;
                    }*/

                    $content = (string)$produit['Designation'];
                    $user_id=1;
                    @$tar=$produit['Tarifs'];
                    @$count=count(@$tar['Prix']);
                    $prix = array();
                    if($count!=0)
                    {
                        if(!empty($tar))
                        {
                            foreach ($tar['Prix'] as $key)
                            {
                                @$var=$key["Tarif"];
                                @$prix["$var"] = $key['Valeur'];
                            }
                        }
                    }
                    if(empty($prix['Public'])){$prix['Public']=0;}
                    if(empty($prix['Promotions'])){$prix['Promotions']="";}
                    $regular_price=(float)$prix['Public'];
                    $promo_price=(float)$prix['Promotions'];
                    @$product_full_image = $produit['Images'];
                    @$product_full_image = $product_full_image['FileName'];
                    //$boolean=true;
                    if($regular_price<1){$boolean=false;}
                    if($Quantite<1){$boolean=false;}
                    // if($boolean==true){$publish="publish";}else{$publish="draft";}

                    if($toPubly=="true"){
                        $publish="publish";
                    }else {
                        $publish="draft";
                    }
                    $post_id=$product_id;

                    $post = array
                    (
                        'ID' => $post_id,
                        'post_author' => $user_id,
                        //'post_content' => $content,
                        'post_status' => $publish,
                        //'post_title' => $title,
                        'post_parent' => '',
                        'post_type' => "product"
                    );


                    //update post
                    wp_update_post( $post );

                    $categ=array();
                    $categ=$name_category;
                    wp_set_object_terms($post_id, $categ, 'product_cat');
                    wp_set_object_terms($post_id, 'simple', 'product_type');
                    update_post_meta( $post_id, '_regular_price', $regular_price );
                    update_post_meta( $post_id, '_price', $regular_price );
                    update_post_meta( $post_id, '_sale_price', '' );

                    if($Marque==002)
                    {
                        // $categ='Nouvel arrivage';
                        $nameNouvelArrivageCategory ='Nouvel arrivage';
                        $categ=array();
                        $categ=array($name_category,$nameNouvelArrivageCategory);
                        wp_set_object_terms($post_id, $categ, 'product_cat');
                    }else {
                        $nameNouvelArrivageCategory ='Nouvel arrivage';
                        $categ=array();
                        $categ=array($nameNouvelArrivageCategory);

                        wp_delete_object_term_relationships( $post_id, $categ );
                    }
                    update_post_meta( $post_id, '_enable_role_based_price', 1 );

                    /*if((!empty($prix['Promotions']))&&(isset($prix['Promotions'])))
                    {
                        update_post_meta( $post_id, '_sale_price', $prix['Promotions'] );
                        update_post_meta( $post_id, '_price', $prix['Promotions'] );
                    }
                    else
                    {
                        delete_post_meta( $post_id, '_sale_price');
                        update_post_meta( $post_id, '_price', $regular_price );
                    }*/

                    if(((!empty($prix['Gros']))&&(isset($prix['Gros'])))||((!empty($prix['Rev']))&&(isset($prix['Rev'])))||((!empty($prix['Administrative']))&&(isset($prix['Administrative'])))
                    )
                    {
                        update_post_meta( $post_id, '_enable_role_based_price', 1 );
                    }
                    if((!empty($prix['Gros']))&&(isset($prix['Gros']))){$Gros=$prix['Gros'];}
                    else{$Gros="";}

                    if((!empty($prix['Rev']))&&(isset($prix['Rev']))){$Rev=$prix['Rev'];}else{$Rev="";}

                    if((!empty($prix['Administrative']))&&(isset($prix['Administrative']))){$Administrative=$prix['Administrative'];}else{$Administrative="";}

                    if((!empty($prix["Soldes"]))&&(isset($prix["Soldes"]))&&($prix["Soldes"]>0))
                    {$soldes=$prix["Soldes"];} else {$soldes="";}



                    if(!empty($soldes)){
                        $codeCategory="solde";
                        $nameCategory=array();
                        $nameCategory=(string)$this->get_category_name_by_code($codeCategory);
                        $nameSoldeCategory ='Soldes';
                        $categ=array();
                        $categ=array($name_category,$nameSoldeCategory);
                        wp_set_object_terms($post_id, $categ, 'product_cat');
                        $roles_price=array
                        (
                            "administrator"=>array
                            (
                                "regular_price"=>"",
                                "selling_price"=>"$soldes"
                            ),
                            "editor"=>array
                            (
                                "regular_price"=>"",
                                "selling_price"=>"$soldes"
                            ),
                            "author"=>array
                            (
                                "regular_price"=>"",
                                "selling_price"=>"$soldes"
                            ),
                            "contributor"=>array
                            (
                                "regular_price"=>"",
                                "selling_price"=>"$soldes"
                            ),
                            "subscriber"=>array
                            (
                                "regular_price"=>"",
                                "selling_price"=>"$soldes"
                            ),
                            "customer"=>array
                            (
                                "regular_price"=>"",
                                "selling_price"=>"$soldes"
                            ),
                            "shop_manager"=>array
                            (
                                "regular_price"=>"",
                                "selling_price"=>"$soldes"
                            ),
                            "grossiste"=>array
                            (
                                "regular_price"=>"$Gros",
                                "selling_price"=>"$soldes"
                            ),
                            "administartion"=>array
                            (
                                "regular_price"=>"$Administrative",
                                "selling_price"=>"$soldes"
                            ),
                            "revs"=>array
                            (
                                "regular_price"=>"$Rev",
                                "selling_price"=>"$soldes"
                            ),
                            "logedout"=>array
                            (
                                "regular_price"=>"",
                                "selling_price"=>""
                            )
                        );
                    } else {

                        $nameSoldeCategory ='Soldes';
                        $categ=array();
                        $categ=array($nameSoldeCategory);

                        wp_delete_object_term_relationships( $post_id, $categ );
                        $roles_price=array
                        (
                            "administrator"=>array
                            (
                                "regular_price"=>"",
                                "selling_price"=>""
                            ),
                            "editor"=>array
                            (
                                "regular_price"=>"",
                                "selling_price"=>""
                            ),
                            "author"=>array
                            (
                                "regular_price"=>"",
                                "selling_price"=>""
                            ),
                            "contributor"=>array
                            (
                                "regular_price"=>"",
                                "selling_price"=>""
                            ),
                            "subscriber"=>array
                            (
                                "regular_price"=>"",
                                "selling_price"=>""
                            ),
                            "customer"=>array
                            (
                                "regular_price"=>"",
                                "selling_price"=>""
                            ),
                            "shop_manager"=>array
                            (
                                "regular_price"=>"",
                                "selling_price"=>""
                            ),
                            "grossiste"=>array
                            (
                                "regular_price"=>"$Gros",
                                "selling_price"=>""
                            ),
                            "administartion"=>array
                            (
                                "regular_price"=>"$Administrative",
                                "selling_price"=>""
                            ),
                            "revs"=>array
                            (
                                "regular_price"=>"$Rev",
                                "selling_price"=>""
                            ),
                            "logedout"=>array
                            (
                                "regular_price"=>"",
                                "selling_price"=>""
                            )
                        );

                    }

                    if((!empty($prix["Promotions"]))&&(isset($prix["Promotions"]))&&($prix["Promotions"]>0))
                    {$promotions=$prix["Promotions"];} else {$promotions="";}
                    if(!empty($promotions)){
                        $codeCategory="promotion";
                        $nameCategory=array();
                        $nameCategory=(string)$this->get_category_name_by_code($codeCategory);
                        $namePromotionCategory ='Promotions';
                        $categ=array();
                        $categ=array($name_category,$namePromotionCategory);
                        wp_set_object_terms($post_id, $categ, 'product_cat');
                        $roles_price=array
                        (
                            "administrator"=>array
                            (
                                "regular_price"=>"",
                                "selling_price"=>"$promotions"
                            ),
                            "editor"=>array
                            (
                                "regular_price"=>"",
                                "selling_price"=>"$promotions"
                            ),
                            "author"=>array
                            (
                                "regular_price"=>"",
                                "selling_price"=>"$promotions"
                            ),
                            "contributor"=>array
                            (
                                "regular_price"=>"",
                                "selling_price"=>"$promotions"
                            ),
                            "subscriber"=>array
                            (
                                "regular_price"=>"",
                                "selling_price"=>"$promotions"
                            ),
                            "customer"=>array
                            (
                                "regular_price"=>"",
                                "selling_price"=>"$promotions"
                            ),
                            "shop_manager"=>array
                            (
                                "regular_price"=>"",
                                "selling_price"=>"$promotions"
                            ),
                            "grossiste"=>array
                            (
                                "regular_price"=>"$Gros",
                                "selling_price"=>"$promotions"
                            ),
                            "administartion"=>array
                            (
                                "regular_price"=>"$Administrative",
                                "selling_price"=>"$promotions"
                            ),
                            "revs"=>array
                            (
                                "regular_price"=>"$Rev",
                                "selling_price"=>"$promotions"
                            ),
                            "logedout"=>array
                            (
                                "regular_price"=>"",
                                "selling_price"=>""
                            )
                        );
                    } else {
                        if(empty($promotions) && empty($soldes)) {
                            $namePromotionCategory ='Promotions';
                            $categ=array();
                            $categ=array($namePromotionCategory);

                            wp_delete_object_term_relationships( $post_id, $categ );
                            $roles_price=array
                            (
                                "administrator"=>array
                                (
                                    "regular_price"=>"",
                                    "selling_price"=>""
                                ),
                                "editor"=>array
                                (
                                    "regular_price"=>"",
                                    "selling_price"=>""
                                ),
                                "author"=>array
                                (
                                    "regular_price"=>"",
                                    "selling_price"=>""
                                ),
                                "contributor"=>array
                                (
                                    "regular_price"=>"",
                                    "selling_price"=>""
                                ),
                                "subscriber"=>array
                                (
                                    "regular_price"=>"",
                                    "selling_price"=>""
                                ),
                                "customer"=>array
                                (
                                    "regular_price"=>"",
                                    "selling_price"=>""
                                ),
                                "shop_manager"=>array
                                (
                                    "regular_price"=>"",
                                    "selling_price"=>""
                                ),
                                "grossiste"=>array
                                (
                                    "regular_price"=>"$Gros",
                                    "selling_price"=>""
                                ),
                                "administartion"=>array
                                (
                                    "regular_price"=>"$Administrative",
                                    "selling_price"=>""
                                ),
                                "revs"=>array
                                (
                                    "regular_price"=>"$Rev",
                                    "selling_price"=>""
                                ),
                                "logedout"=>array
                                (
                                    "regular_price"=>"",
                                    "selling_price"=>""
                                )
                            );
                        } else {
                            if(empty($promotions) && !empty($soldes)){
                                $namePromotionCategory ='Promotions';
                                $categ=array();
                                $categ=array($namePromotionCategory);
                                wp_delete_object_term_relationships( $post_id, $categ );
                            }
                        }


                    }



                    update_post_meta( $post_id, '_role_based_price', $roles_price );

                    $ProductMonth = get_the_date( 'm', $post_id );
                    $ProductYear = get_the_date( 'Y', $post_id );
                    /***
                     **
                     *
                    RECUPERE IMAGE PRODUITS
                     *
                     **
                     ***/

                    if(!empty($product_full_image))
                    {
                        $dir = dirname(__FILE__);
                        $home=esc_url( home_url( '/' ) );
                        $imageO =  $home.'wp-content/plugins/syncix/Images/Large/'.$product_full_image;
                        $image1 =  'Images/Large/'.$product_full_image;
                        if(file_exists($image1))
                        {
                            // error_log( $imageO." Exist");
                            require_once(ABSPATH . 'wp-admin/includes/media.php');
                            require_once(ABSPATH . 'wp-admin/includes/file.php');
                            require_once(ABSPATH . 'wp-admin/includes/image.php');

                            $media = media_sideload_image($imageO, $post_id);
                            if(!empty($media) && !is_wp_error($media))
                            {
                                $args = array
                                (
                                    'post_type' => 'attachment',
                                    'posts_per_page' => -1,
                                    'post_status' => 'any',
                                    'post_parent' => $post_id
                                );
                                $attachments = get_posts($args);
                                if(isset($attachments) && is_array($attachments))
                                {
                                    foreach($attachments as $attachment)
                                    {
                                        // grab source of full size images (so no 300x150 nonsense in path)
                                        $image = wp_get_attachment_image_src($attachment->ID, 'full');
                                        // determine if in the $media image we created, the string of the URL exists
                                        if(strpos($media, $image[0]) !== false)
                                        {
                                            // if so, we found our image. set it as thumbnail
                                            set_post_thumbnail($post_id, $attachment->ID);
                                            // only want one image
                                            break;
                                        }
                                    }
                                }
                            }
                            // error_log("Image Product $product_sku added");
                            // unlink ($image1);
                        }
                    }
                    update_post_meta( $product_id, '_last_modified_time', $produit['LastModifiedDate'] );

                    error_log( "Traitement du produit N° ".$i." SKU : ".$product_sku." ID : ".$post_id." effectué avec succés");
                    $i++;
                }

            }
            else {

                $title = (string)$produit['Designation'];

                @$Quantite = (int)$produit['Quantite'];
                @$category_code = (string)$produit['Famille'];
                @$Marque = (int)$produit['Marque'];
                @$toPubly = $produit['ToPubly'];

                $name_category=(string)$this->get_category_name_by_code($category_code);

                /*$term = get_term_by( 'name', $name_category, 'product_cat' );
                $categoryId = $term->term_id;

                $parentcats = get_ancestors($categoryId, 'product_cat');
                if(!empty($parentcats)){
                        $parentId = $parentcats[0];
                        $term = get_term_by( 'id', $parentId, 'product_cat' );
                        $name_category = $term->name;
                }*/

                $content = (string)$produit['Designation'];
                $user_id=1;
                @$tar=$produit['Tarifs'];
                @$count=count(@$tar['Prix']);


                $prix = array();
                if($count!=0)
                {
                    if(!empty($tar))
                    {
                        foreach ($tar['Prix'] as $key)
                        {
                            @$var=$key["Tarif"];
                            @$prix["$var"] = $key['Valeur'];
                        }
                    }
                }
                if(empty($prix['Public'])){$prix['Public']=0;}
                if(empty($prix['Promotions'])){$prix['Promotions']="";}

                $regular_price=(float)$prix['Public'];
                $promo_price=(float)$prix['Promotions'];
                /*@$product_full_image = $produit['Images'];
                @$product_full_image = $product_full_image['FileName'];*/
                //$boolean=true;
                if($regular_price<1){$boolean=false;}
                if($Quantite<1){$boolean=false;}
                // if($boolean==true){$publish="publish";}else{$publish="draft";}

                if($toPubly=="true"){
                    $publish="publish";
                }else {
                    $publish="draft";
                }
                /**
                 * AJOUTER LE PRODUIT
                 **/

                $post = array
                (
                    'post_author' => $user_id,
                    'post_content' => $content,
                    'post_status' => $publish,
                    'post_title' => $title,
                    'post_parent' => '',
                    'post_type' => "product"
                );

                //Create post
                $post_id = wp_insert_post( $post );

                //Categories products
                $categ=array();
                $categ=$name_category;
                if($Marque==002)
                {
                    // $categ='Nouvel arrivage';
                    $nameNouvelArrivageCategory ='Nouvel arrivage';
                    $categ=array();
                    $categ=array($name_category,$nameNouvelArrivageCategory);
                    wp_set_object_terms($post_id, $categ, 'product_cat');
                }else {
                    $nameNouvelArrivageCategory ='Nouvel arrivage';
                    $categ=array();
                    $categ=array($nameNouvelArrivageCategory);

                    wp_delete_object_term_relationships( $post_id, $categ );
                }

                wp_set_object_terms($post_id, $categ, 'product_cat');
                wp_set_object_terms($post_id, 'simple', 'product_type');

                //Meta products
                update_post_meta( $post_id, '_visibility', 'visible' );
                update_post_meta( $post_id, '_stock_status', 'instock');
                update_post_meta( $post_id, 'total_sales', '0');
                update_post_meta( $post_id, '_downloadable', 'yes');
                update_post_meta( $post_id, '_virtual', 'yes');
                update_post_meta( $post_id, '_regular_price', $regular_price );
                update_post_meta( $post_id, '_price', $regular_price );
                update_post_meta( $post_id, '_sale_price', '' );
                /*if((!empty($prix['Promotions']))&&(isset($prix['Promotions']))){
                    update_post_meta( $post_id, '_sale_price', $prix['Promotions'] );
                    update_post_meta( $post_id, '_price', $prix['Promotions'] );
                }
                else
                {
                    delete_post_meta( $post_id, '_sale_price');
                    update_post_meta( $post_id, '_price', $regular_price );
                }*/
                update_post_meta( $post_id, '_sku', $product_sku);
                update_post_meta( $post_id, '_manage_stock', "no" );
                update_post_meta( $post_id, '_backorders', "no" );

                if(
                    (!empty($prix['Gros']) && (isset($prix['Gros']))) ||
                    (!empty($prix['Rev']) && (isset($prix['Rev']))) ||
                    (!empty($prix['Administrative']) && (isset($prix['Administrative'])))
                )
                {
                    update_post_meta( $post_id, '_enable_role_based_price', 1 );
                }

                if((!empty($prix['Gros']))&&(isset($prix['Gros'])))
                {
                    $Gros = $prix['Gros'];
                }
                else
                {
                    $Gros="";
                }

                if((!empty($prix['Rev']))&&(isset($prix['Rev'])))
                {
                    $Rev = $prix['Rev'];
                }
                else
                {
                    $Rev="";
                }
                if((!empty($prix['Administrative']))&&(isset($prix['Administrative'])))
                {
                    $Administrative = $prix['Administrative'];
                }
                else
                {
                    $Administrative="";

                }
                if((!empty($prix["Soldes"]))&&(isset($prix["Soldes"]))&&($prix["Soldes"]>0)){$soldes=$prix["Soldes"];}else{$soldes="";}

                if(!empty($soldes)){
                    $codeCategory="solde";
                    $nameCategory=array();
                    $nameCategory=(string)$this->get_category_name_by_code($codeCategory);
                    $nameSoldeCategory ='Soldes';
                    $categ=array();
                    $categ=array($name_category,$nameSoldeCategory);
                    wp_set_object_terms($post_id, $categ, 'product_cat');


                    $roles_price=array
                    (
                        "administrator"=>array
                        (
                            "regular_price"=>"",
                            "selling_price"=>"$soldes"
                        ),
                        "editor"=>array
                        (
                            "regular_price"=>"",
                            "selling_price"=>"$soldes"
                        ),
                        "author"=>array
                        (
                            "regular_price"=>"",
                            "selling_price"=>"$soldes"
                        ),
                        "contributor"=>array
                        (
                            "regular_price"=>"",
                            "selling_price"=>"$soldes"
                        ),
                        "subscriber"=>array
                        (
                            "regular_price"=>"",
                            "selling_price"=>"$soldes"
                        ),
                        "customer"=>array
                        (
                            "regular_price"=>"",
                            "selling_price"=>"$soldes"
                        ),
                        "shop_manager"=>array
                        (
                            "regular_price"=>"",
                            "selling_price"=>"$soldes"
                        ),
                        "grossiste"=>array
                        (
                            "regular_price"=>"$Gros",
                            "selling_price"=>"$soldes"
                        ),
                        "administartion"=>array
                        (
                            "regular_price"=>"$Administrative",
                            "selling_price"=>"$soldes"
                        ),
                        "revs"=>array
                        (
                            "regular_price"=>"$Rev",
                            "selling_price"=>"$soldes"
                        ),
                        "logedout"=>array
                        (
                            "regular_price"=>"",
                            "selling_price"=>""
                        )
                    );
                } else {
                    $nameSoldeCategory ='Soldes';
                    $categ=array();
                    $categ=array($nameSoldeCategory);

                    wp_delete_object_term_relationships( $post_id, $categ );
                    $roles_price=array
                    (
                        "administrator"=>array
                        (
                            "regular_price"=>"",
                            "selling_price"=>""
                        ),
                        "editor"=>array
                        (
                            "regular_price"=>"",
                            "selling_price"=>""
                        ),
                        "author"=>array
                        (
                            "regular_price"=>"",
                            "selling_price"=>""
                        ),
                        "contributor"=>array
                        (
                            "regular_price"=>"",
                            "selling_price"=>""
                        ),
                        "subscriber"=>array
                        (
                            "regular_price"=>"",
                            "selling_price"=>""
                        ),
                        "customer"=>array
                        (
                            "regular_price"=>"",
                            "selling_price"=>""
                        ),
                        "shop_manager"=>array
                        (
                            "regular_price"=>"",
                            "selling_price"=>""
                        ),
                        "grossiste"=>array
                        (
                            "regular_price"=>"$Gros",
                            "selling_price"=>""
                        ),
                        "administartion"=>array
                        (
                            "regular_price"=>"$Administrative",
                            "selling_price"=>""
                        ),
                        "revs"=>array
                        (
                            "regular_price"=>"$Rev",
                            "selling_price"=>""
                        ),
                        "logedout"=>array
                        (
                            "regular_price"=>"",
                            "selling_price"=>""
                        )
                    );
                }

                if((!empty($prix["Promotions"]))&&(isset($prix["Promotions"]))&&($prix["Promotions"]>0)){$promotions=$prix["Promotions"];}else{$promotions="";}

                if(!empty($promotions)){
                    $codeCategory="promotion";
                    $nameCategory=array();
                    $nameCategory=(string)$this->get_category_name_by_code($codeCategory);
                    $namePromotionCategory ='Promotions';
                    $categ=array();
                    $categ=array($name_category,$namePromotionCategory);
                    wp_set_object_terms($post_id, $categ, 'product_cat');
                    $roles_price=array
                    (
                        "administrator"=>array
                        (
                            "regular_price"=>"",
                            "selling_price"=>"$promotions"
                        ),
                        "editor"=>array
                        (
                            "regular_price"=>"",
                            "selling_price"=>"$promotions"
                        ),
                        "author"=>array
                        (
                            "regular_price"=>"",
                            "selling_price"=>"$promotions"
                        ),
                        "contributor"=>array
                        (
                            "regular_price"=>"",
                            "selling_price"=>"$promotions"
                        ),
                        "subscriber"=>array
                        (
                            "regular_price"=>"",
                            "selling_price"=>"$promotions"
                        ),
                        "customer"=>array
                        (
                            "regular_price"=>"",
                            "selling_price"=>"$promotions"
                        ),
                        "shop_manager"=>array
                        (
                            "regular_price"=>"",
                            "selling_price"=>"$promotions"
                        ),
                        "grossiste"=>array
                        (
                            "regular_price"=>"$Gros",
                            "selling_price"=>"$promotions"
                        ),
                        "administartion"=>array
                        (
                            "regular_price"=>"$Administrative",
                            "selling_price"=>"$promotions"
                        ),
                        "revs"=>array
                        (
                            "regular_price"=>"$Rev",
                            "selling_price"=>"$promotions"
                        ),
                        "logedout"=>array
                        (
                            "regular_price"=>"",
                            "selling_price"=>""
                        )
                    );
                } else {
                    if(empty($promotions) && empty($soldes)) {
                        $namePromotionCategory ='Promotions';
                        $categ=array();
                        $categ=array($namePromotionCategory);

                        wp_delete_object_term_relationships( $post_id, $categ );
                        $roles_price=array
                        (
                            "administrator"=>array
                            (
                                "regular_price"=>"",
                                "selling_price"=>""
                            ),
                            "editor"=>array
                            (
                                "regular_price"=>"",
                                "selling_price"=>""
                            ),
                            "author"=>array
                            (
                                "regular_price"=>"",
                                "selling_price"=>""
                            ),
                            "contributor"=>array
                            (
                                "regular_price"=>"",
                                "selling_price"=>""
                            ),
                            "subscriber"=>array
                            (
                                "regular_price"=>"",
                                "selling_price"=>""
                            ),
                            "customer"=>array
                            (
                                "regular_price"=>"",
                                "selling_price"=>""
                            ),
                            "shop_manager"=>array
                            (
                                "regular_price"=>"",
                                "selling_price"=>""
                            ),
                            "grossiste"=>array
                            (
                                "regular_price"=>"$Gros",
                                "selling_price"=>""
                            ),
                            "administartion"=>array
                            (
                                "regular_price"=>"$Administrative",
                                "selling_price"=>""
                            ),
                            "revs"=>array
                            (
                                "regular_price"=>"$Rev",
                                "selling_price"=>""
                            ),
                            "logedout"=>array
                            (
                                "regular_price"=>"",
                                "selling_price"=>""
                            )
                        );
                    } else {
                        if(empty($promotions) && !empty($soldes)){
                            $namePromotionCategory ='Promotions';
                            $categ=array();
                            $categ=array($namePromotionCategory);

                            wp_delete_object_term_relationships( $post_id, $categ );
                        }
                    }


                }







                update_post_meta( $post_id, '_role_based_price', $roles_price );



                /***
                 **
                 *
                RECUPERE IMAGE PRODUITS
                 *
                 **
                 ***/


                /*if(!empty($product_full_image))
                {
                    $dir = dirname(__FILE__);
                    $home=esc_url( home_url( '/' ) );
                    $imageO =  $home.'wp-content/plugins/syncix/Images/Large/'.$product_full_image;
                    $image1 =  'Images/Large/'.$product_full_image;
                    if(file_exists($image1))
                    {
                        // error_log( $imageO." Exist");
                               require_once(ABSPATH . 'wp-admin/includes/media.php');
                               require_once(ABSPATH . 'wp-admin/includes/file.php');
                               require_once(ABSPATH . 'wp-admin/includes/image.php');

                        $media = media_sideload_image($imageO, $post_id);
                        if(!empty($media) && !is_wp_error($media))
                        {
                            $args = array
                            (
                                'post_type' => 'attachment',
                                'posts_per_page' => -1,
                                'post_status' => 'any',
                                'post_parent' => $post_id
                            );
                            $attachments = get_posts($args);
                            if(isset($attachments) && is_array($attachments))
                            {
                                foreach($attachments as $attachment)
                                {
                                     // grab source of full size images (so no 300x150 nonsense in path)
                                     $image = wp_get_attachment_image_src($attachment->ID, 'full');
                                     // determine if in the $media image we created, the string of the URL exists
                                    if(strpos($media, $image[0]) !== false)
                                    {
                                        // if so, we found our image. set it as thumbnail
                                        set_post_thumbnail($post_id, $attachment->ID);
                                       // only want one image
                                        break;
                                    }
                                }
                            }
                        }
                        // error_log("Image Product $product_sku added");
                        // unlink ($image1);
                    }
                }*/

                update_post_meta( $product_id, '_last_modified_time', $produit['LastModifiedDate'] );

                error_log( "Traitement du produit N° ".$i." SKU : ".$product_sku." ID : ".$post_id." effectué avec succés");
            }
        }
        wp_defer_term_counting(true);
        wp_defer_comment_counting(false);
    }






    function create_zip($files = array(),$destination = '',$overwrite = false)
    {
        //if the zip file already exists and overwrite is false, return false
        if(file_exists($destination) && !$overwrite) { return false; }
        //vars
        $valid_files = array();
        //if files were passed in...
        if(is_array($files)) {
            //cycle through each file
            foreach($files as $file) {
                //make sure the file exists
                if(file_exists($file)) {
                    $valid_files[] = $file;
                }
            }
        }
        //if we have good files...
        if(count($valid_files)) {
            //create the archive
            $zip = new ZipArchive();
            if($zip->open($destination,$overwrite ? ZIPARCHIVE::OVERWRITE : ZIPARCHIVE::CREATE) !== true) {
                return false;
            }
            //add the files
            foreach($valid_files as $file) {
                $zip->addFile($file,$file);
            }
            //debug
            //echo 'The zip archive contains ',$zip->numFiles,' files with a status of ',$zip->status;

            //close the zip -- done!
            $zip->close();

            //check to make sure the file exists
            return file_exists($destination);
        }
        else
        {
            return false;
        }
    }

}
?>