/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Author:  David
 * Created: Jan 30, 2017
 */

//----------------------- Get pay_grade_earning_deduction_codes -----------------------
SELECT 
`pay_grade_earning_deductions`.id,
`pay_grade_earning_deductions`.earning_deduction_id,
`pay_grade_earning_deductions`.amount,
`pay_grade_earning_deductions`.date_created,
`payroll_earning_deduction_codes`.earning_deduction_name,
`pay_grades`.pay_grade_id
FROM `pay_grade_earning_deductions` 
JOIN `pay_grades` on `pay_grade_earning_deductions`.`pay_grade_id` = `pay_grades`.`pay_grade_id`
JOIN `payroll_earning_deduction_codes` ON `pay_grade_earning_deductions`.`earning_deduction_id` = `payroll_earning_deduction_codes`.`earning_deduction_id`;
//---------------------------------------- END ---------------------------------------- 

//----------------------- Get pay_grade_earning_deduction_codes dropdown -----------------------

##optimize this query since its slow
SELECT `earning_deduction_id`,`company_id`,`earning_deduction_name` FROM `payroll_earning_deduction_codes` 
WHERE earning_deduction_id NOT IN(
    SELECT earning_deduction_id
    FROM `pay_grade_earning_deductions` WHERE pay_grade_id = 1
)

SELECT 
`payroll_earning_deduction_codes`.earning_deduction_id,
`payroll_earning_deduction_codes`.company_id,
`payroll_earning_deduction_codes`.earning_deduction_name
FROM `pay_grade_earning_deductions` 
RIGHT JOIN `payroll_earning_deduction_codes`
ON `payroll_earning_deduction_codes`.`earning_deduction_id` = `pay_grade_earning_deductions`.`earning_deduction_id`
WHERE `pay_grade_earning_deductions`.`id` IS NULL;
//---------------------------------------- END ----------------------------------------

CREATE TRIGGER `group_master_date_time` BEFORE INSERT ON `group_master`
 FOR EACH ROW SET NEW.date_created = NOW()
 
 CREATE TRIGGER `sub_groups_date_time` BEFORE INSERT ON `sub_groups`
 FOR EACH ROW SET NEW.date_created = NOW()
  


