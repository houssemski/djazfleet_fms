<?php
App::uses('Parameter', 'Model');
if (class_exists('Enum') != true) {
    include(APP . 'Controller' . DS . "Enum.php");
}
if (class_exists('ParametersEnum') != true) {
    include(APP . 'Controller' . DS . "ParametersEnum.php");
}
/**
 * Parameter Test Case
 *
 * @property Parameter $Parameter
 */
class ParameterTestCase extends CakeTestCase
{
    public $fixtures = array('app.parameter');

    public function setUp()
    {
        parent::setUp();
        $this->Parameter = ClassRegistry::init('Parameter');
    }

    public function testGetCodesParameterVal()
    {
        $result = $this->Parameter->getCodesParameterVal('name_car');
        $this->assertContains($result, [1, 2]);

        $result = $this->Parameter->getCodesParameterVal('param_coupon');
        $this->assertContains($result, [1, 2]);

        $result = $this->Parameter->getCodesParameterVal('select_coupon');
        $this->assertContains($result, [1, 2]);

        $result = $this->Parameter->getCodesParameterVal('departure_tank_state');
        $this->assertContains($result, [1, 2]);

        $result = $this->Parameter->getCodesParameterVal('take_account_departure_tank');
        $this->assertContains($result, [1, 2]);

        $this->Parameter->getCodesParameterVal('signature_mission_order');

        $result = $this->Parameter->getCodesParameterVal('entete_pdf');
        $this->assertContains($result, [1, 2]);

        $result = $this->Parameter->getCodesParameterVal('reference_mi_auto');
        $this->assertContains($result, [1, 2]);
    }

    // know if rubric's code is auto and get length of code
    public function testGetCodeTypeAndSize()
    {
        $result = $this->Parameter->getCodeTypeAndSize('car');
        if (!empty($result)) {
            $this->assertContains($result['Parameter']['auto_car'], [0, 1]);
            $this->assertNotEmpty($result['Parameter']['sizes_car']);
        }
        $result = $this->Parameter->getCodeTypeAndSize('conductor');
        if (!empty($result)) {
            $this->assertContains($result['Parameter']['auto_conductor'], [0, 1]);
            $this->assertNotEmpty($result['Parameter']['sizes_conductor']);
        }
    }

    // know if rubric's reference is auto
    public function testGetReferenceInfos()
    {
        $result = $this->Parameter->getReferenceInfos('affectation');
        if (!empty($result)) {
            $this->assertNotEmpty($result['Parameter']['reference_sizes_affectation']);
        }

        $result = $this->Parameter->getReferenceInfos('event');
        if (!empty($result)) {
            $this->assertNotEmpty($result['Parameter']['reference_sizes_event']);
        }
    }

    // know if rubric's code is auto and get length of code
    public function testGetTransportBillReferenceInfos()
    {
        $result = $this->Parameter->getTransportBillReferenceInfos('reference_dd_auto');
        if (!empty($result)) {
            $this->assertNotEmpty($result['Parameter']['reference_sizes']);
        }

        $result = $this->Parameter->getTransportBillReferenceInfos('reference_fp_auto');
        if (!empty($result)) {
            $this->assertNotEmpty($result['Parameter']['reference_sizes']);
        }

        $result = $this->Parameter->getTransportBillReferenceInfos('reference_bc_auto');
        if (!empty($result)) {
            $this->assertNotEmpty($result['Parameter']['reference_sizes']);
        }

        $result = $this->Parameter->getTransportBillReferenceInfos('reference_fr_auto');
        if (!empty($result)) {
            $this->assertNotEmpty($result['Parameter']['reference_sizes']);
        }

        $result = $this->Parameter->getTransportBillReferenceInfos('reference_pf_auto');
        if (!empty($result)) {
            $this->assertNotEmpty($result['Parameter']['reference_sizes']);
        }

        $result = $this->Parameter->getTransportBillReferenceInfos('reference_fa_auto');
        if (!empty($result)) {
            $this->assertNotEmpty($result['Parameter']['reference_sizes']);
        }

    }

    public function testGetFieldsToHide()
    {
        $result = $this->Parameter->getFieldsToHide();
        $this->assertInternalType('array',$result);
    }

    public function testGetParamValByCode()
    {
        $result = $this->Parameter->getParamValByCode(ParametersEnum::assurance, array('val'));
        $this->assertInternalType('array',$result);

        $result = $this->Parameter->getParamValByCode(ParametersEnum::km_restant_contrat, array('val'));
        $this->assertInternalType('array',$result);

        $result = $this->Parameter->getParamValByCode(ParametersEnum::contrat_vehicule, array('val'));
        $this->assertInternalType('array',$result);

        $result = $this->Parameter->getParamValByCode(ParametersEnum::expiration_permis, array('val'));
        $this->assertInternalType('array',$result);

        $result = $this->Parameter->getParamValByCode(ParametersEnum::amortissement, array('val'));
        $this->assertInternalType('array',$result);

        $result = $this->Parameter->getParamValByCode(ParametersEnum::limite_mensuelle_consommation, array('val'));
        $this->assertInternalType('array',$result);

        $result = $this->Parameter->getParamValByCode(ParametersEnum::nb_minimum_bons, array('val'));
        $this->assertInternalType('array',$result);

        $result = $this->Parameter->getParamValByCode(ParametersEnum::controle_technique, array('val'));
        $this->assertInternalType('array',$result);

        $result = $this->Parameter->getParamValByCode(ParametersEnum::vignette, array('val'));
        $this->assertInternalType('array',$result);

        $result = $this->Parameter->getParamValByCode(ParametersEnum::avec_date, array('val'));
        $this->assertInternalType('array',$result);

        $result = $this->Parameter->getParamValByCode(ParametersEnum::vidange, array('val'));
        $this->assertInternalType('array',$result);

        $result = $this->Parameter->getParamValByCode(ParametersEnum::vidange_engins, array('val'));
        $this->assertInternalType('array',$result);

        $result = $this->Parameter->getParamValByCode(ParametersEnum::avec_km, array('val'));
        $this->assertInternalType('array',$result);

        $result = $this->Parameter->getParamValByCode(ParametersEnum::depots, array('depot'));
        $this->assertInternalType('array',$result);

        $result = $this->Parameter->getParamValByCode(
            ParametersEnum::codes,
            array('consumption_coupon', 'consumption_spacies', 'consumption_tank', 'consumption_card')
        );
        $this->assertInternalType('array',$result);

        $result = $this->Parameter->getParamValByCode(ParametersEnum::codes, array('affectation_mode'));
        $this->assertInternalType('array',$result);

        $result = $this->Parameter->getParamValByCode(ParametersEnum::codes, array('balance_car'));
        $this->assertInternalType('array',$result);

        $result = $this->Parameter->getParamValByCode(ParametersEnum::codes, array('priority'));
        $this->assertInternalType('array',$result);

        $result = $this->Parameter->getParamValByCode(
            ParametersEnum::codes,
            array('nb_ride', 'param_marchandise', 'param_price')
        );
        $this->assertInternalType('array',$result);

        $result = $this->Parameter->getParamValByCode(
            ParametersEnum::codes,
            array('param_price')
        );
        $this->assertInternalType('array',$result);

        $result = $this->Parameter->getParamValByCode(
            ParametersEnum::codes,
            array('separator_amount')
        );
        $this->assertInternalType('array',$result);

        $result = $this->Parameter->getParamValByCode(ParametersEnum::codes, array('select_coupon'));
        $this->assertInternalType('array',$result);

        $result = $this->Parameter->getParamValByCode(ParametersEnum::codes, array('use_priority'));
        $this->assertInternalType('array',$result);

        $result = $this->Parameter->getParamValByCode(ParametersEnum::codes, array('display_mission_cost'));
        $this->assertInternalType('array',$result);

        $result =$this->Parameter->getParamValByCode(ParametersEnum::codes, array('mission_cost_day'));
        $this->assertInternalType('array',$result);

        $result = $this->Parameter->getParamValByCode(ParametersEnum::codes, array('choice_reporting'));
        $this->assertInternalType('array',$result);

        $result =$this->Parameter->getParamValByCode(ParametersEnum::codes, array('use_ride_category'));
        $this->assertInternalType('array',$result);

        $result = $this->Parameter->getParamValByCode(
            ParametersEnum::codes,
            array(
                'loading_time',
                'unloading_time',
                'maximum_driving_time',
                'break_time',
                'additional_time_allowed'
            )
        );
        $this->assertInternalType('array',$result);

        $result = $this->Parameter->getParamValByCode(ParametersEnum::codes, array('sheet_ride_name'));
        $this->assertInternalType('array',$result);

        

    }

}