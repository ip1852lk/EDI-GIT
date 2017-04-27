<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CustomerTest
 *
 * @author JB
 */
class DashboardTest extends CDbTestCase
{

    public function testGetYearData()
    {
        $model = new Dashboard();
        $years = $model->getYearData();
        $this->assertEquals(
                array(), $years
        );
    }

    public function testAddition()
    {
        $var1 = 1;
        $var2 = 2;
        $this->assertEquals(
                $var1 + $var2, 3
        );
    }

}
