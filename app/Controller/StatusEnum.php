<?php
/**
 * Created by PhpStorm.
 * User: billal
 * Date: 08-09-2018
 * Time: 15:45
 */

class StatusEnum extends Enum {
    const sheetride_planned = "1";
    const sheetride_ongoing = "2";
    const sheetride_back_to_parc = "3";
    const sheetride_closed = "4";
    const mission_planned = "1";
    const mission_ongoing = "2";
    const mission_closed = "3";
    const quotation = "0";
    const not_validated = "1";
    const partially_validated = "2";
    const validated = "3";
    const mission_pre_invoiced = "4";
    const mission_approved = "5";
    const mission_not_approved = "6";
    const mission_invoiced = "7";
    const mission_credit_note = "10";
    const not_transmitted = "8";
    const canceled = "9";
    const credit_note = "10";
    const intervention_planned ="1";
    const intervention_ongoing ="2";
    const intervention_finished ="3";
    const intervention_canceled ="4";

    const status_planned ="1";
    const status_ongoing ="2";
    const status_closed ="3";
    const status_by_date ="4";

}
