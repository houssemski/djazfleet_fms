<?php
App::uses('HttpSocket', 'Network/Http');
/**

 * @author kahina
 */
class Cafyb extends AppModel
{

    function cUrlGetData($url, $post_fields = null, $headers = null)
    {
        $ch = curl_init();
        $timeout = 3000;
        curl_setopt($ch, CURLOPT_URL, $url);
        if ($post_fields && !empty($post_fields)) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
        }
        if ($headers && !empty($headers)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $data = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);
        $data = utf8_encode($data);
        $data = json_decode($data, JSON_UNESCAPED_UNICODE);
        return $data;
    }

    function getPaymentById($paymentId = null){
        $link = "getPaymentById/".$paymentId;
        $headers = array("Content-Type:application/json");
        $payment = $this->cUrlGetData($link, null, $headers);
        // first array  payment = array(
        //            'Payment.id',
        //            'Payment.operation_date',
        //            'Payment.receipt_date',
        //            'Payment.value_date',
        //            'Payment.amount',
        //            'Payment.payment_type',
        //            'Compte.num_compte',
        //            'Payment.wording',
        //            'Supplier.name',
        //);
        return $payment;
    }

    function getPaymentsByCarId($carId = null){
        $link = "getPaymentsByCarId/".$carId;
        $headers = array("Content-Type:application/json");
        $payments = $this->cUrlGetData($link, null, $headers);
        // array payments = array('Compte.num_compte',
        //                        'Payment.wording',
        //                        'Payment.receipt_date',
        //                        'Payment.payment_type',
        //                        'Payment.amount');
        return $payments;
    }

    function savePayments($payments = null){
        // array payments = array('Payment.car_id',
        // 'Payment.supplier_id',
        // 'Payment.wording',
        // 'Payment.compte_id',
        // 'Payment.transact_type_id',
        // 'Payment.receipt_date',
        // 'Payment.amount',
        // 'Payment.payment_type',
        // 'Payment.note',
        //);
        $payments = json_encode($payments);
        /*$this->response->type('json');
        $this->response->body($payments);
        return $this->response; */
        $linkCafyb = Configure::read("link_cafyb");
        $link = $linkCafyb."/payments/savePayments/".$payments;
        $headers = array("Content-Type:application/json");
        $save = $this->cUrlGetData($link, null, $headers);
        return $save;
    }

    function savePayment($payment=null){
        // array payment = array(
        // 'Payment.supplier_id',
        // 'Payment.wording',
        // 'Payment.number_payment',
        // 'Payment.compte_id',
        // 'Payment.transact_type_id',
        // 'Payment.receipt_date',
        // 'Payment.operation_date',
        // 'Payment.value_date',
        // 'Payment.amount',
        // 'Payment.payment_type',
        // 'Payment.payment_etat',
        // 'Payment.note',
        //);
        $payment = json_encode($payment);
        $link = "savePayment/".$payment;
        $headers = array("Content-Type:application/json");
        $save = $this->cUrlGetData($link, null, $headers);
        return $save;
    }

    function saveMoneyTransfer($payment=null){
        // array payment = array(
        // 'Payment.supplier_id',
        // 'Payment.wording',
        // 'Payment.number_payment',
        // 'Payment.origin_compte_id',
        // 'Payment.destination_compte_id',
        // 'Payment.transact_type_id',
        // 'Payment.receipt_date',
        // 'Payment.value_date',
        // 'Payment.amount',
        // 'Payment.payment_type',
        // 'Payment.payment_etat',
        //);
        $payment = json_encode($payment);
        $link = "saveMoneyTransfer/".$payment;
        $headers = array("Content-Type:application/json");
        $save = $this->cUrlGetData($link, null, $headers);
        return $save;
    }

    function deletePaymentsByCarId( $carId = null){

        $carId = json_encode($carId);
        /*$this->response->type('json');
        $this->response->body($carId);
        return $this->response; */
        $link = "deletePaymentsByCarId/".$carId;
        $headers = array("Content-Type:application/json");
        $delete = $this->cUrlGetData($link, null, $headers);
        return $delete;
    }
    function getPayments(){
        $link = "getPayments";
        $headers = array("Content-Type:application/json");
        $payments = $this->cUrlGetData($link, null, $headers);
        // list array $payments = array(
        //'Payment.id',
        //'Payment.wording',
        //'Payment.operation_date',
        //'Payment.receipt_date',
        //'Payment.value_date',
        //'Payment.deadline_date',
        //'Payment.transact_type_id',
        //'Payment.amount',
        //'Payment.payment_type',
        //'Payment.payment_etat',
        //'Payment.payment_category_id',
        //'PaymentCategory.name',
        //'Compte.num_compte',
        //'Customer.first_name',
        //'Customer.last_name',
        //'Supplier.name',
        //'Interfering.name',
        //'PaymentAssociation.name',
        //'PaymentAssociation.id'
        //);
        return $payments;

    }

    function getComptes(){

        $link = "getComptes";
        $headers = array("Content-Type:application/json");
        $comptes = $this->cUrlGetData($link, null, $headers);
        // list array comptes = array('Compte.num_compte',
        //                        'Compte.num_compte',);
        return $comptes;
    }

    function getComptesByIds($comptesIds=null){
        $link = "getComptesByIds/".$comptesIds;
        $headers = array("Content-Type:application/json");
        $comptes = $this->cUrlGetData($link, null, $headers);
        // list array comptes = array('Compte.id',
        //                        'Compte.num_compte',);
        return $comptes;
    }

    function getAllComptes(){

        $link = "getAllComptes";
        $headers = array("Content-Type:application/json");
        $comptes = $this->cUrlGetData($link, null, $headers);
        // all array comptes = array('Compte.id',
        //                        'Compte.num_compte',
        //                          'Compte.type',
        //                          'Compte.type_id',
        //                          'Compte.rib',
        //                          'Compte.agency',
        //                          'Compte.amount',
        //                          'Compte.created',
        //                          'Compte.modified',
        //
        //          );
        return $comptes;
    }

    function getCompteById($compteId=null){
        $link = "getCompteById/".$compteId;
        $headers = array("Content-Type:application/json");
        $compte = $this->cUrlGetData($link, null, $headers);
        // first array  compte = array('Compte.id',
        //                        'Compte.num_compte',
        //                          'Compte.type',
        //                          'Compte.type_id',
        //                          'Compte.rib',
        //                          'Compte.agency',
        //                          'Compte.amount',
        //                          'Compte.created',
        //                          'Compte.modified',
        //);
        return $compte;
    }

    function addCompte($compte=null){
        // array compte = array(
        //                        'Compte.num_compte',
        //                          'Compte.type',
        //                          'Compte.type_id',
        //                          'Compte.rib',
        //                          'Compte.agency',
        //                          'Compte.amount',
        //);
        $compte = json_encode($compte);
        $link = "addCompte/".$compte;
        $headers = array("Content-Type:application/json");
        $save = $this->cUrlGetData($link, null, $headers);
        return $save;
    }

    function editCompte($compte=null){
        // array compte = array(
        //                        'Compte.id',
        //                        'Compte.num_compte',
        //                          'Compte.type',
        //                          'Compte.type_id',
        //                          'Compte.rib',
        //                          'Compte.agency',
        //                          'Compte.amount',
        //);
        $compte = json_encode($compte);
        $link = "editCompte/".$compte;
        $headers = array("Content-Type:application/json");
        $save = $this->cUrlGetData($link, null, $headers);
        return $save;
    }

    function deleteCompte( $compteId = null)
    {

        $compteId = json_encode($compteId);
        /*$this->response->type('json');
        $this->response->body($carId);
        return $this->response; */
        $link = "deleteCompte/" . $compteId;
        $headers = array("Content-Type:application/json");
        $delete = $this->cUrlGetData($link, null, $headers);
        return $delete;
    }

    function getAccountsByConditions($conditions=null){
        $conditions= base64_encode(serialize($conditions));
        $linkCafyb = Configure::read("link_cafyb");
        $link = $linkCafyb."/Synchronizations/getAccountsByConditions/".$conditions;

        $headers = array("Content-Type:application/json");
        $comptes = $this->cUrlGetData($link, null, $headers);
        // list array comptes = array('Compte.id',
        //                        'Compte.num_compte',);
        return $comptes;
    }
    function getAccountByConditions($conditions=null){
        $conditions= base64_encode(serialize($conditions));
        $linkCafyb = Configure::read("link_cafyb");

        $link = $linkCafyb."/Synchronizations/getAccountByConditionsAndOrder/".$conditions;
        $headers = array("Content-Type:application/json");
        $compte = $this->cUrlGetData($link, null, $headers);
        // j'ai besoin du 1er compte cest tt
        // list array compte = array('Compte.id',
        //                        'Compte.num_compte',);
        return $compte;
    }

    function getUsers(){
        $link = "getUsers";
        $headers = array("Content-Type:application/json");
        $users = $this->cUrlGetData($link, null, $headers);
        // list array users = array('User.id',
        //                        'User.first_name',
        //                         'User.last_name');
        return $users;
    }
    function getUserProfiles(){
        $link = "getProfiles";
        $headers = array("Content-Type:application/json");
        $profiles = $this->cUrlGetData($link, null, $headers);
        // list array profiles = array('Profile.id',
        //                        'Profile.name',);
        return $profiles;
    }
    function getSuppliers(){
        $link = "getSuppliers";
        $headers = array("Content-Type:application/json");
        $suppliers = $this->cUrlGetData($link, null, $headers);
        // list array suppliers = array('Supplier.id',
        //                        'Supplier.name',);
        return $suppliers;

    }
    function getCustomers(){
        $link = "getCustomers";
        $headers = array("Content-Type:application/json");
        $customers = $this->cUrlGetData($link, null, $headers);
        // list array customers = array('Customer.id',
        //                        'Customer.name',);
        return $customers;
    }
    function getTiers(){
        $link = "getTiers";
        $headers = array("Content-Type:application/json");
        $tiers = $this->cUrlGetData($link, null, $headers);
        // list array customers = array('Supplier.id',
        //                        'Supplier.name',);
        return $tiers;
    }

    function getPaymentCategories(){
        $link = "getPaymentCategories";
        $headers = array("Content-Type:application/json");
        $paymentCategories = $this->cUrlGetData($link, null, $headers);
        // list array paymentCategories = array('PaymentCategory.id',
        //                        'PaymentCategory.name',);
        return $paymentCategories;
    }
    function getSumCredit(){

        $link = "getSumCredit";
        $headers = array("Content-Type:application/json");
        $sumCredit = $this->cUrlGetData($link, null, $headers);
        return $sumCredit;
    }
    function getSumDebit(){
        $link = "getSumDebit";
        $headers = array("Content-Type:application/json");
        $sumDebit = $this->cUrlGetData($link, null, $headers);
        return $sumDebit;
    }

    function getAllProducts(){

        $link = "getAllProducts";
        $headers = array("Content-Type:application/json");
        $products = $this->cUrlGetData($link, null, $headers);
        // all array products = array(
        //                          'Product.id',
        //                          'Product.code',
        //                          'Product.name',
        //                          'ProductFamily.name',
        //                          'Tva.name',
        //                          'Product.quantity',
        //                          'Product.quantity_min',
        //                          'Product.quantity_max',
        //                          'Product.pmp',
        //
        //          );
        return $products;
    }
    public function getProducts(){
        $linkCafyb = Configure::read("link_cafyb");
        $link = $linkCafyb."/Synchronizations/getProducts";
        //$headers = array("Content-Type:application/json");
        //$products = $this->cUrlGetData($link, null, $headers);
        $data = null;
        $httpSocket = new HttpSocket();
        $request = array(
            'header' => array('Content-Type' => 'application/json',
            ),
        );
        $response = $httpSocket->get($link, $data, $request);
        $this->set('response_code', $response->code);
        $this->set('response_body', $response->body);
        $chaine = $response->body;
        $chaine = utf8_encode($chaine);
        $products = json_decode($chaine, JSON_UNESCAPED_UNICODE);
        // all array products = array(
        //                          'Product.id',
        //                          'Product.name',
        //
        //          );
        return $products;
    }

    public function getAccounts(){
        $linkCafyb = Configure::read("link_cafyb");
        $link = $linkCafyb."/Synchronizations/getAccounts";
        //$headers = array("Content-Type:application/json");
        //$products = $this->cUrlGetData($link, null, $headers);
        $data = null;
        $httpSocket = new HttpSocket();
        $request = array(
            'header' => array('Content-Type' => 'application/json',
            ),
        );
        $response = $httpSocket->get($link, $data, $request);
        $this->set('response_code', $response->code);
        $this->set('response_body', $response->body);
        $chaine = $response->body;
        $chaine = utf8_encode($chaine);
        $accounts = json_decode($chaine, JSON_UNESCAPED_UNICODE);
        // all array products = array(
        //                          'Product.id',
        //                          'Product.name',
        //
        //          );
        return $accounts;
    }

    public function getPaymentMethods(){
        $linkCafyb = Configure::read("link_cafyb");
        $link = $linkCafyb."/Synchronizations/getPaymentMethods";
        //$headers = array("Content-Type:application/json");
        //$products = $this->cUrlGetData($link, null, $headers);
        $data = null;
        $httpSocket = new HttpSocket();
        $request = array(
            'header' => array('Content-Type' => 'application/json',
            ),
        );
        $response = $httpSocket->get($link, $data, $request);
        $this->set('response_code', $response->code);
        $this->set('response_body', $response->body);
        $chaine = $response->body;
        $chaine = utf8_encode($chaine);
        $paymentMethods = json_decode($chaine, JSON_UNESCAPED_UNICODE);
        // all array products = array(
        //                          'Product.id',
        //                          'Product.name',
        //
        //          );
        return $paymentMethods;
    }
    function addDocument($bill=null,$products=null, $typeDoc=null, $internalExternal=null,  $thirdPartyId=null){



        $linkCafyb = Configure::read("link_cafyb");
        $link = $linkCafyb."/documents/addDocument/".$bill."/".$products."/".$typeDoc."/".$internalExternal."/".$thirdPartyId;

        $headers = array("Content-Type:application/json");
        $save = $this->cUrlGetData($link, null, $headers);
        return $save;
    }
    function addPayment($payment=null){
        $payment = base64_encode(serialize($payment));
        $linkCafyb = Configure::read("link_cafyb");
        $link = $linkCafyb."/payments/addPayment/".$payment;
        $headers = array("Content-Type:application/json");
        $save = $this->cUrlGetData($link, null, $headers);
        return $save;
    }
    function addThirdParty($name=null,$thirdPartyType=null){
        $linkCafyb = Configure::read("link_cafyb");
        $link = $linkCafyb."/third-parties/addThirdParty/".$name.'/'.$thirdPartyType;

        $headers = array("Content-Type:application/json");
        $thirdPartyId = $this->cUrlGetData($link, null, $headers);

        return $thirdPartyId;
    }

    function getProductById($productId=null){
        $linkCafyb = Configure::read("link_cafyb");
        $link = $linkCafyb."/Synchronizations/getProductById/".$productId;
        $headers = array("Content-Type:application/json");
        $product = $this->cUrlGetData($link, null, $headers);


        // first array  $product = array(
        //                          'Product.id',
        //                          'Product.code',
        //                          'Product.reference',
        //                          'ProductFamily.name',
        //                          'ProductCategory.name',
        //                          'ProductMark.name',
        //                          'ProductUnit.name',
        //                          'Tva.name',
        //                          'Product.remark',
        //                          'Product.changeable_price',
        //                          'Product.blocked',
        //                          'Product.out_stock',
        //                          'Product.quantity',
        //                          'Product.quantity_min',
        //                          'Product.quantity_max',
        //                          'Product.pmp',
        //                          'Product.last_purchase_price',
        //                          'Product.weight',
        //                          'Product.volume',
        //                          'Product.emplacement',
        //                          'Product.description',
        //);
        return $product;
    }
    function getPaymentsByEventId($eventId=null){
        $linkCafyb = Configure::read("link_cafyb");
        $link = $linkCafyb."/Synchronizations/getPaymentsByEventId/".$eventId;
        $headers = array("Content-Type:application/json");
        $arrayPayments = $this->cUrlGetData($link, null, $headers);
        $i= 0;
        $payments = array();
        foreach ($arrayPayments as $arrayPayment){
            $payments[$i]['Payment']['reference'] = $arrayPayment['label'];
            $payments[$i]['Payment']['receipt_date'] = $arrayPayment['receipt_date'];
            $payments[$i]['Payment']['amount'] = $arrayPayment['amount'];
            $payments[$i]['Payment']['note'] = $arrayPayment['note'];
            $payments[$i]['Payment']['payment_type'] = $arrayPayment['payment_method_id'];
            $payments[$i]['Payment']['compte_id'] = $arrayPayment['account_id'];


            $i++;
        }
        return $payments;
    }

    function addProduct($product=null){
        // array $product = array(
        //);
        $product = json_encode($product);
        $link = "addProduct/".$product;
        $headers = array("Content-Type:application/json");
        $save = $this->cUrlGetData($link, null, $headers);
        return $save;
    }

    function editProduct($product=null){
        // array product = array(
        //);
        $product = json_encode($product);
        $link = "editProduct/".$product;
        $headers = array("Content-Type:application/json");
        $save = $this->cUrlGetData($link, null, $headers);
        return $save;
    }

    function deleteProduct( $productId = null)
    {

        $productId = json_encode($productId);
        /*$this->response->type('json');
        $this->response->body($carId);
        return $this->response; */
        $link = "deleteProduct/" . $productId;
        $headers = array("Content-Type:application/json");
        $delete = $this->cUrlGetData($link, null, $headers);
        return $delete;
    }


    function getDepots(){
        $link = "getDepots";
        $headers = array("Content-Type:application/json");
        $depots = $this->cUrlGetData($link, null, $headers);
        // list array $depots = array(
        //                         'Depot.id',
        //                        'Depot.name',
        //);
        return $depots;
    }
    function getTvas(){
        $link = "getTvas";
        $headers = array("Content-Type:application/json");
        $tvas = $this->cUrlGetData($link, null, $headers);
        // list array $tvas = array(
        //                         'Tva.id',
        //                        'Tva.name',
        //);
        return $tvas;
    }
    function getProductCategories(){
        $link = "getProductCategories";
        $headers = array("Content-Type:application/json");
        $productCategories = $this->cUrlGetData($link, null, $headers);
        // list array $productCategories = array(
        //
        //        //                         'ProductCategory.id',
        //        //                        'ProductCategory.name',
        //
        //);
        return $productCategories;
    }

    function getProductMarks(){
        $link = "getProductCategories";
        $headers = array("Content-Type:application/json");
        $productMarks = $this->cUrlGetData($link, null, $headers);
        // list array $productMarks = array(
        //        //                         'ProductMark.id',
        //        //                        'ProductMark.name',);
        return $productMarks;
    }

    function getProductFamilies(){
        $link = "getProductCategories";
        $headers = array("Content-Type:application/json");
        $productFamilies = $this->cUrlGetData($link, null, $headers);
        // list array $productFamilies = array(
        //        //                         'ProductFamily.id',
        //        //                        'ProductFamily.name',);
        return $productFamilies;
    }

    function getProductTypes(){
        $link = "getProductTypes";
        $headers = array("Content-Type:application/json");
        $productTypes = $this->cUrlGetData($link, null, $headers);
        // list array $productTypes = array(
        //        //                         'ProductType.id',
        //        //                        'ProductType.name',);
        return $productTypes;
    }
    function getProductUnits(){
        $link = "getProductUnits";
        $headers = array("Content-Type:application/json");
        $productUnits = $this->cUrlGetData($link, null, $headers);
        // list array $productUnits = array(
        //        //                         'ProductUnit.id',
        //        //                        'ProductUnit.name',);
        return $productUnits;
    }



    // cest le user existe cette fonction return un tableau
    // exist = true plus les informations du user et tte ses permission
    // si le user nexiste pas la fonction return false
    // voici un exemple de la reponse de cette fonction
    /*  $response['exist'] =1;
        $response['User.id'] =1;
        $response['User.first_name'] = 'superadmin';
        $response['User.last_name'] = 'superadmin';
        $response['User.email'] = 'utranx@intellixweb.com';
        $response['User.service_id'] = NULL;
        $response['User.profile_id'] = '1';
        $response['User.role_id'] = '3';
        $response['User.limit'] = '3';
        $response['Permission.car.index'] = 1;
        $response['Permission.car.add'] = 1;
        $response['Permission.car.edit'] = 1;
        $response['Permission.car.delete'] = 1;
        $response['Permission.payment.index'] = 1;
        $response['Permission.payment.add'] = 1;
        $response['Permission.payment.edit'] = 1;
        $response['Permission.payment.delete'] = 1;
        $response['Permission.payment.encaissement'] = 1;
        $response['Permission.payment.decaissement'] = 1;
        $response['Permission.payment.virement'] = 1;
        $response['Permission.compte.index'] = 1;
        $response['Permission.compte.add'] = 1;
        $response['Permission.compte.edit'] = 1;
        $response['Permission.compte.delete'] = 1;
        $response['Permission.product.index'] = 1;
        $response['Permission.product.add'] = 1;
        $response['Permission.product.edit'] = 1;
        $response['Permission.product.delete'] = 1;
    */
    function getUserIfExist($username, $password){
        $link = "getUserIfExist/".$username."/".$password;

        $headers = array("Content-Type:application/json");

        $response = $this->cUrlGetData($link, null, $headers);
        return $response;
    }

    function getInformationUser($userId=null){
        $linkCafyb = Configure::read("link_cafyb");
        $link = $linkCafyb."/Synchronizations/getInformationUser/".$userId;

        $headers = array("Content-Type:application/json");

        $user = $this->cUrlGetData($link, null, $headers);

        return $user;
    }
    function synchSite(){
        $link = "http://ghpharma-dz.com/wp-content/plugins/syncix/server.php";

        $headers = array("Content-Type:application/json");

        $response = $this->cUrlGetData($link, null, $headers);
        var_dump($response); die();
        return $response;
    }



    public function writeInformationUser ($user = null){


        $response['User.id'] =$user['id'];
        $response['User.first_name'] = $user['first_name'];
        $response['User.last_name'] = $user['last_name'];
        $response['User.email'] = 'utranx@intellixweb.com';
        $response['User.service_id'] = NULL;
        $response['User.profile_id'] = '1';
        $response['User.role_id'] = '3';
        $response['User.limit'] = '3';


    }




}