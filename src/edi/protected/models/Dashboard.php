<?php

/**
 * Dashboard class.
 */
class Dashboard extends CFormModel
{

    const TYPE_SALES_VALUE = 0;
    const TYPE_QUANTITY = 1;
    const TYPE_HIT = 2;

    public $yearData;
    public $selectedYear;
    public $typeData;
    public $selectedType;
    public $stateData;
    public $selectedState;
    public $customerData;
    public $selectedCustomers;
    public $selectedFacility;
    public $selectedLocation;
    public $selectedItem;


    public static function getColors(){
        return array(
            '#E75063',
            '#7DC566',
            '#6697D2',
            '#F2A55D',
            '#9A60AA',
            '#C56B59',
            '#D178B3',
            '#707070',
        );
//        return array(
//            '#010202',
//            '#E21938',
//            '#3C8D45',
//            '#3C54A7',
//            '#E6782E',
//            '#631F8F',
//            '#981026',
//            '#AD2793',
//        );
//        return array(
//            '#3398DB',
//            '#F7CA18',//yellow
//            '#E74C3C',
//            '#7DB831',
//            '#F39C12',
//            '#05756A',
//            '#3398DB',//Blue
//            '#16a085',//Green
//            '#f39c12',//Orange
//            '#e74c3c',//red
//            '#8e44ad',//purple
//            '#05756A',//dark green
////            '#E8E8E8',//grey
//        );
//        return array(
//            '#A4E3FE',
//            '#C0EC5F',
//            '#BAC3CC',
//            '#FF5F5F',
//            '#233545',
//            '#13C4A5',
//            '#5B98D4',
//            '#F4C413',
//            '#233445',
//            '#EBECEC',
//            '#B867D8',
//            '#2B3F6B',
//        );
    }


    public static function time_elapsed_string($datetime, $full = false) {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }

    public function getAlerts(){
        //Targets Set
        $baseUrl = Yii::app()->baseUrl;
        $alerts = array();
        $user = Yii::app()->user->getId();
        $user = User::model()->findByPk($user);
//        if(isset($user->profile->CO1_ID) &&  $user->profile->CO1_ID !== 0){
//            if(!TargetEntry::model()->checkIfTargetSet($user->profile->CO1_ID)){
//                $alerts[] = "<a style='color:white;'href='".$baseUrl."/targetEntry/'>The Targets need to be set for your company. Click here.</a>";
//            }
//        }
        return $alerts;

    }


    public function init()
    {
        parent::init();
        // Access Right
        $isAdmin = Yii::app()->user->checkAccess('Admin');
        $isCustomer = Yii::app()->user->checkAccess('Customer');
        $isSupplier = Yii::app()->user->checkAccess('Supplier');
        if (!$isAdmin && $isCustomer)
            $cu1_id = Yii::app()->user->getState('cu1_id');
        else
            $cu1_id = 0;
        // Year data
        $this->yearData = $this->getYearData($cu1_id);
        $this->selectedYear = reset($this->yearData);
        // Type data
        $this->typeData = array(
            self::TYPE_SALES_VALUE => !$isAdmin && $isCustomer ? 'Purchase Value' : 'Sales Value',
            self::TYPE_QUANTITY => !$isAdmin && $isCustomer ? 'Purchase Quantity' : 'Sales Quantity',
            self::TYPE_HIT => 'Order Lines',
        );
        $this->selectedType = self::TYPE_SALES_VALUE;
        // State Data
        $this->stateData = $this->getStateData();
        $this->selectedState = 0;
        // Customer Data
        $this->customerData = $this->getCustomerData($cu1_id);
        if (!$isAdmin && $isCustomer) {
            $this->selectedCustomers = array(Yii::app()->user->getState('cu1_id'));
        } elseif (!$isAdmin && $isSupplier) {
            $this->selectedCustomers = array();
        } else {
            $this->selectedCustomers = array();
        }
        // Facility Data
        $this->selectedFacility = 0;
        // Location data
        $this->selectedLocation = 0;
        // Item data
        $this->selectedItem = 0;
    }

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules()
    {
        return array(
            //
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels()
    {
        return array(
            //
        );
    }

    /**
     * Returns the year data.
     * @return array
     */
    public function getYearData($cu1_id=0)
    {
        $yearData = Yii::app()->cache->get('yearData' . ($cu1_id>0 ? '-c' . $cu1_id : ''));
        if ($yearData === false) {
            $yearData = array();
            try {
                $connection = Yii::app()->db;
                $connection->active = true;
                $sql =
                    "SELECT " .
                    "DISTINCT bi2_usage.bi2_year " .
                    "FROM bi2_usage " .
                    "LEFT JOIN bi1_bin ON (bi1_bin.id=bi2_usage.bi1_id) " .
                    "LEFT JOIN it1_item ON (it1_item.id=bi1_bin.it1_id) " .
                    "LEFT JOIN lo1_location ON (lo1_location.id=it1_item.lo1_id) " .
                    "LEFT JOIN fa1_facility ON (fa1_facility.id=lo1_location.fa1_id) " .
                    "WHERE " .
                    ($cu1_id>0 ? '(fa1_facility.cu1_id=:cu1_id) AND ' : '') .
                    "(bi2_usage.delete_flag=0) " .
                    "GROUP BY bi2_usage.bi2_year " .
                    "ORDER BY bi2_usage.bi2_year DESC";
                $command = $connection->createCommand($sql);
                if ($cu1_id>0)
                    $command->bindParam(":cu1_id", $cu1_id, PDO::PARAM_INT);
                $dataReader = $command->query();
                $rows = $dataReader->readAll();
                $connection->active = false;
                // Data
                foreach ($rows as $row) {
                    $yearData[$row['bi2_year']] = (int) $row['bi2_year'];
                }
                if (count($yearData) == 0) {
                    $thisYear = date('Y');
                    for ($i = 0; $i < 5; $i++) {
                        $yearData[$thisYear - $i] = $thisYear - $i;
                    }
                }
                // Cache
                Yii::app()->cache->set(
                    'yearData' . ($cu1_id>0 ? '-c' . $cu1_id : ''), $yearData, Yii::app()->params['dashboardYearDataCacheDuration']);
            } catch (Exception $ex) {
                $ex->getMessage();
            }
        }
        return $yearData;
    }

    /**
     * Returns customers
     * @return array
     */
    public function getCustomerData($cu1_id)
    {
        $customerData = Yii::app()->cache->get('customerData' . ($cu1_id>0 ? '-c' . $cu1_id : ''));
        if ($customerData === false) {
            // Data
            $alias = Customer::model()->getTableAlias(false, false);
            $criteria = new CDbCriteria();
            if ($cu1_id>0) {
                $criteria->addCondition($alias . '.id=:cu1_id', 'AND');
                $criteria->params = array(':cu1_id' => $cu1_id);
            }
            $criteria->order = $alias . '.cu1_name ASC';
            $criteria->limit = -1;
            $customerModel = new Customer();
            $customers = $customerModel->findAll($criteria);
            $customerData = array();
            foreach ($customers as $customer) {
                //if (!array_key_exists('<span class="label label-info">' . Customer::itemAlias("customerTypes", $customer->cu1_type) . '</span>', $customerData)) {
                //    $customerData['<span class="label label-info">' . Customer::itemAlias("customerTypes", $customer->cu1_type) . '</span>'] = array();
                //}
                //$customerData['<span class="label label-info">' . Customer::itemAlias("customerTypes", $customer->cu1_type) . '</span>'][$customer->id] = $customer->cu1_name;
                if (!array_key_exists(Customer::itemAlias("customerTypes", $customer->cu1_type), $customerData)) {
                    $customerData[Customer::itemAlias("customerTypes", $customer->cu1_type)] = array();
                }
                $customerData[Customer::itemAlias("customerTypes", $customer->cu1_type)][$customer->id] = $customer->cu1_name;
            }
            // Cache
            Yii::app()->cache->set(
                'customerData' . ($cu1_id>0 ? '-c' . $cu1_id : ''), $customerData, Yii::app()->params['dashboardCustomerDataCacheDuration']);
        }
        return $customerData;
    }

    /**
     * Returns states
     * @return array
     */
    public function getStateData()
    {
        $stateData = Yii::app()->cache->get('stateData2');
        if ($stateData === false) {
            // Data
            $stateModel = new State();
            $stateData = $stateModel->findAll();
            // Cache
            Yii::app()->cache->set(
                'stateData2', $stateData, Yii::app()->params['dashboardStateDataCacheDuration']);
        }
        return $stateData;
    }

    ////////////////////////////////////////////////////////////////////////////
    // Map
    /**
     * Returns the map data.
     * @return array
     */
    public function getMapData()
    {
        $mapData = Yii::app()->cache->get(
            'mapData-' . $this->selectedYear . '-' . $this->selectedType . '-' . implode('-', $this->selectedCustomers));
        if ($mapData === false) {
            $data = array();
            foreach ($this->stateData as $state) {
                $data[] = array(
                    'st1_id' => $state->id,
                    'st1_code' => $state->st1_code,
                    'st1_name' => $state->st1_name,
                    'customers' => 0,
                    'qty' => 0,
                    'hit' => 0,
                    'dollar' => 0,
                    'code' => $state->st1_code,
                    'value' => 0,
                );
            }
            try {
                $connection = Yii::app()->db;
                $connection->active = true;
                $sql =
                    "SELECT " .
                    "fa1_facility.st1_id, " .
                    "st1_state.st1_code, " .
                    "st1_state.st1_name, " .
                    "COUNT(DISTINCT fa1_facility.cu1_id) AS customers, " .
                    "COUNT(DISTINCT lo1_location.fa1_id) AS facilities, " .
                    "COUNT(DISTINCT it1_item.lo1_id) AS locations, " .
                    "COUNT(DISTINCT bi1_bin.it1_id) AS items, " .
                    "ROUND(SUM(bi2_usage.bi2_value), 0) AS total_value, " .
                    "SUM(bi2_usage.bi2_qty) AS total_qty, " .
                    "SUM(bi2_usage.bi2_hit) AS total_hit " .
                    "FROM bi2_usage " .
                    "LEFT JOIN bi1_bin ON (bi1_bin.id=bi2_usage.bi1_id) " .
                    "LEFT JOIN it1_item ON (it1_item.id=bi1_bin.it1_id) " .
                    "LEFT JOIN lo1_location ON (lo1_location.id=it1_item.lo1_id) " .
                    "LEFT JOIN fa1_facility ON (fa1_facility.id=lo1_location.fa1_id) " .
                    "LEFT JOIN st1_state ON (st1_state.id=fa1_facility.st1_id) " .
                    "WHERE " .
                    "(bi2_usage.bi2_year=:selectedYear) AND " .
                    ($this->selectedCustomers && count($this->selectedCustomers) > 0 ? "(fa1_facility.cu1_id IN (" . implode(',', $this->selectedCustomers) . ")) AND " : "") .
                    "(bi2_usage.delete_flag=0) " .
                    "GROUP BY fa1_facility.st1_id";
                $command = $connection->createCommand($sql);
                $command->bindParam(":selectedYear", $this->selectedYear, PDO::PARAM_INT);
                $dataReader = $command->query();
                $rows = $dataReader->readAll();
                $connection->active = false;
                // Data
                $len = count($data);
                $customers = 0;
                $facilities = 0;
                $locations = 0;
                $items = 0;
                $total_value = 0;
                $total_qty = 0;
                $total_hit = 0;
                foreach ($rows as $row) {
                    $customers += (int) $row['customers'];
                    $facilities += (int) $row['facilities'];
                    $locations += (int) $row['locations'];
                    $items += (int) $row['items'];
                    $total_value += (double) $row['total_value'];
                    $total_qty += (int) $row['total_qty'];
                    $total_hit += (int) $row['total_hit'];
                    for ($i = 0; $i < $len; $i++) {
                        if ($data[$i]['st1_id'] === $row['st1_id']) {
                            $data[$i]['customers'] = (int) $row['customers'];
                            $data[$i]['facilities'] = (int) $row['facilities'];
                            $data[$i]['locations'] = (int) $row['locations'];
                            $data[$i]['items'] = (int) $row['items'];
                            $data[$i]['dollar'] = (double) $row['total_value'];
                            $data[$i]['qty'] = (int) $row['total_qty'];
                            $data[$i]['hit'] = (int) $row['total_hit'];
                            if ($this->selectedType == self::TYPE_QUANTITY) {
                                $data[$i]['value'] = (int) $row['total_qty'];
                            } elseif ($this->selectedType == self::TYPE_HIT) {
                                $data[$i]['value'] = (int) $row['total_hit'];
                            } else {
                                $data[$i]['value'] = (double) $row['total_value'];
                            }
                        }
                    }
                }
                $mapData = array(
                    'customers' => $customers,
                    'facilities' => $facilities,
                    'locations' => $locations,
                    'items' => $items,
                    'value' => $total_value,
                    'qty' => $total_qty,
                    'hit' => $total_hit,
                    'mapdata' => $data,
                );
                // Cache
                Yii::app()->cache->set(
                    'mapData-' . $this->selectedYear . '-' . $this->selectedType . '-' . implode('-', $this->selectedCustomers), $mapData, Yii::app()->params['dashboardMapDataCacheDuration']);
            } catch (Exception $ex) {
                $ex->getMessage();
            }
        }
        return $mapData;
    }

    ////////////////////////////////////////////////////////////////////////////
    // Top 5 Customers
    /**
     * Returns the top 5 customers' sales data by facility.
     * @return CArrayDataProvider
     */
    public function getTop5CustomersSales()
    {
        $top5CustomersSales = Yii::app()->cache->get(
            'top5CustomersSales-' . $this->selectedYear . '-' . $this->selectedType . '-' . implode('-', $this->selectedCustomers));
        if ($top5CustomersSales === false) {
            try {
                $connection = Yii::app()->db;
                $connection->active = true;
                $sql =
                    "SELECT " .
                    "if(SUM(if(bi2_usage.bi2_month BETWEEN 1 AND 6, bi2_usage.bi2_value, 0))>0, SUM(if(bi2_usage.bi2_month BETWEEN 7 AND 12, bi2_usage.bi2_value, 0))/SUM(if(bi2_usage.bi2_month BETWEEN 1 AND 6, bi2_usage.bi2_value, 0))*100, 100) AS trend, " .
                    "fa1_facility.cu1_id AS id, " .
                    "cu1_customer.cu1_type, " .
                    "cu1_customer.cu1_code, " .
                    "cu1_customer.cu1_name, " .
                    "SUM(bi2_usage.bi2_qty) AS total_qty, " .
                    "SUM(bi2_usage.bi2_hit) AS total_hit, " .
                    "ROUND(SUM(bi2_usage.bi2_value), 2) AS total_value " .
                    "FROM bi2_usage " .
                    "LEFT JOIN bi1_bin ON (bi1_bin.id=bi2_usage.bi1_id) " .
                    "LEFT JOIN it1_item ON (it1_item.id=bi1_bin.it1_id) " .
                    "LEFT JOIN lo1_location ON (lo1_location.id=it1_item.lo1_id) " .
                    "LEFT JOIN fa1_facility ON (fa1_facility.id=lo1_location.fa1_id) " .
                    "LEFT JOIN cu1_customer ON (cu1_customer.id=fa1_facility.cu1_id) " .
                    "WHERE " .
                    "(bi2_usage.bi2_year=:selectedYear) AND " .
                    ($this->selectedCustomers && count($this->selectedCustomers) > 0 ? "(fa1_facility.cu1_id IN (" . implode(',', $this->selectedCustomers) . ")) AND " : "") .
                    "(bi2_usage.delete_flag=0) " .
                    "GROUP BY fa1_facility.cu1_id " .
                    "ORDER BY " .
                    ($this->selectedType == self::TYPE_QUANTITY ? 'total_qty' : ($this->selectedType == self::TYPE_HIT ? 'total_hit' : 'total_value')) . " DESC " .
                    "LIMIT " . Yii::app()->params['dashboardCustomerLimit'];
                $command = $connection->createCommand($sql);
                $command->bindParam(":selectedYear", $this->selectedYear, PDO::PARAM_INT);
                $dataReader = $command->query();
                $rows = $dataReader->readAll();
                $connection->active = false;
                // Data
                if ($rows === null) {
                    $rows = array();
                } elseif (Yii::app()->params['dashboardShowRandomTrend']) {
                    $len = count($rows);
                    for ($i = 0; $i < $len; $i++) {
                        $rows[$i]['trend'] = rand(0, 200);
                    }
                }
                $top5CustomersSales = new CArrayDataProvider($rows, array(
                    'id' => 'id',
                    'sort' => array(
                        'attributes' => array(
                            'total_value',
                            'total_qty',
                            'total_hit',
                        ),
                        'defaultOrder' => array(
                            ($this->selectedType == self::TYPE_QUANTITY ? 'total_qty' : ($this->selectedType == self::TYPE_HIT ? 'total_hit' : 'total_value')) => CSort::SORT_DESC
                        ),
                    ),
                    'pagination' => array(
                        'pageSize' => Yii::app()->params['dashboardCustomerLimit'],
                    ),
                ));
                // Cache
                Yii::app()->cache->set(
                    'top5CustomersSales-' . $this->selectedYear . '-' . $this->selectedType . '-' . implode('-', $this->selectedCustomers), $top5CustomersSales, Yii::app()->params['dashboardTop5CustomersSalesCacheDuration']);
            } catch (Exception $ex) {
                $ex->getMessage();
            }
        }
        return $top5CustomersSales;
    }

    ////////////////////////////////////////////////////////////////////////////
    // State
    /**
     * Returns the state's sales data by customer.
     * @return array
     */
    public function getStatePieChartData()
    {
        $statePieChartData = Yii::app()->cache->get(
            'statePieChartData-' . $this->selectedYear . '-' . $this->selectedType . '-' . implode('-', $this->selectedCustomers) . '-' . $this->selectedState);
        if ($statePieChartData === false) {
            try {
                $connection = Yii::app()->db;
                $connection->active = true;
                $sql =
                    "SELECT " .
                    "fa1_facility.cu1_id AS cu1_id, " .
                    "cu1_customer.cu1_code, " .
                    "cu1_customer.cu1_name, " .
                    "fa1_facility.st1_id, " .
                    "st1_state.st1_code, " .
                    "st1_state.st1_name, " .
                    "COUNT(DISTINCT lo1_location.fa1_id) AS facilities, " .
                    "COUNT(DISTINCT it1_item.lo1_id) AS locations, " .
                    "COUNT(DISTINCT bi1_bin.it1_id) AS items, " .
                    "SUM(bi2_usage.bi2_qty) AS qty, " .
                    "SUM(bi2_usage.bi2_hit) AS hit, " .
                    "ROUND(SUM(bi2_usage.bi2_value), 2) AS dollar " .
                    "FROM bi2_usage " .
                    "LEFT JOIN bi1_bin ON (bi1_bin.id=bi2_usage.bi1_id) " .
                    "LEFT JOIN it1_item ON (it1_item.id=bi1_bin.it1_id) " .
                    "LEFT JOIN lo1_location ON (lo1_location.id=it1_item.lo1_id) " .
                    "LEFT JOIN fa1_facility ON (fa1_facility.id=lo1_location.fa1_id) " .
                    "LEFT JOIN cu1_customer ON (cu1_customer.id=fa1_facility.cu1_id) " .
                    ($this->selectedState > 0 ? "LEFT JOIN st1_state ON (st1_state.id=fa1_facility.st1_id) " : "") .
                    "WHERE " .
                    "(bi2_usage.bi2_year=:selectedYear) AND " .
                    ($this->selectedCustomers && count($this->selectedCustomers) > 0 ? "(fa1_facility.cu1_id IN (" . implode(',', $this->selectedCustomers) . ")) AND " : "") .
                    ($this->selectedState > 0 ? "(fa1_facility.st1_id=:selectedState) AND " : "") .
                    "(bi2_usage.delete_flag=0) " .
                    "GROUP BY fa1_facility.cu1_id";
                $command = $connection->createCommand($sql);
                $command->bindParam(":selectedYear", $this->selectedYear, PDO::PARAM_INT);
                if ($this->selectedState > 0)
                    $command->bindParam(":selectedState", $this->selectedState, PDO::PARAM_INT);
                $dataReader = $command->query();
                $rows = $dataReader->readAll();
                if (is_null($rows))
                    $rows = array();
                $connection->active = false;
                // Data
                $len = count($rows);
                $total = 0;
                $total_value = 0;
                $total_qty = 0;
                $total_hit = 0;
                $data = array();
                for ($i = 0; $i < $len; $i++) {
                    $row = $rows[$i];
                    // Total Value
                    $total_value += (double) $row['dollar'];
                    $total_qty += (int) $row['qty'];
                    $total_hit += (int) $row['hit'];
                    // Customer Data
                    $data[$row['cu1_id']] = array();
                    $data[$row['cu1_id']]['name'] = $row['cu1_name'];
                    if ($this->selectedType == self::TYPE_QUANTITY) {
                        $total += (int) $row['qty'];
                        $data[$row['cu1_id']]['y'] = (int) $row['qty'];
                    } elseif ($this->selectedType == self::TYPE_HIT) {
                        $total += (int) $row['hit'];
                        $data[$row['cu1_id']]['y'] = (int) $row['hit'];
                    } else {
                        $total += (double) $row['dollar'];
                        $data[$row['cu1_id']]['y'] = (double) $row['dollar'];
                    }
                    if ($this->selectedState > 0) {
                        $data[$row['cu1_id']]['st1_id'] = $row['st1_id'];
                        $data[$row['cu1_id']]['st1_code'] = $row['st1_code'];
                        $data[$row['cu1_id']]['st1_name'] = $row['st1_name'];
                    } else {
                        $data[$row['cu1_id']]['st1_id'] = '';
                        $data[$row['cu1_id']]['st1_code'] = '';
                        $data[$row['cu1_id']]['st1_name'] = '';
                    }
                    $data[$row['cu1_id']]['cu1_id'] = $row['cu1_id'];
                    $data[$row['cu1_id']]['cu1_code'] = $row['cu1_code'];
                    $data[$row['cu1_id']]['cu1_name'] = $row['cu1_name'];
                    $data[$row['cu1_id']]['facilities'] = (int) $row['facilities'];
                    $data[$row['cu1_id']]['locations'] = (int) $row['locations'];
                    $data[$row['cu1_id']]['items'] = (int) $row['items'];
                    $data[$row['cu1_id']]['qty'] = (int) $row['qty'];
                    $data[$row['cu1_id']]['hit'] = (int) $row['hit'];
                    $data[$row['cu1_id']]['dollar'] = (double) $row['dollar'];
                }
                // JSON Data
                $customerData = array();
                foreach ($data as $customer) {
                    $customerData[] = array(
                        'name' => $customer['name'],
                        'y' => round($customer['y'] / $total * 100, 1),
                        'st1_id' => $customer['st1_id'],
                        'st1_code' => $customer['st1_code'],
                        'st1_name' => $customer['st1_name'],
                        'cu1_id' => $customer['cu1_id'],
                        'cu1_code' => $customer['cu1_code'],
                        'cu1_name' => $customer['cu1_name'],
                        'facilities' => $customer['facilities'],
                        'locations' => $customer['locations'],
                        'items' => $customer['items'],
                        'qty' => $customer['qty'],
                        'hit' => $customer['hit'],
                        'dollar' => $customer['dollar'],
                    );
                }
                $statePieChartData = array(
                    'customerData' => $customerData,
                    'value' => $total_value,
                    'qty' => $total_qty,
                    'hit' => $total_hit,
                );
                // Cache
                Yii::app()->cache->set(
                    'statePieChartData-' . $this->selectedYear . '-' . $this->selectedType . '-' . implode('-', $this->selectedCustomers) . '-' . $this->selectedState, $statePieChartData, Yii::app()->params['dashboardStatePieChartDataCacheDuration']);
            } catch (Exception $ex) {
                $ex->getMessage();
            }
        }
        return $statePieChartData;
    }

    /**
     * Returns the state's sales data by customer.
     * @return CArrayDataProvider
     */
    public function getStateSalesData()
    {
        $stateSalesData = Yii::app()->cache->get(
            'stateSalesData-' . $this->selectedYear . '-' . $this->selectedType . '-' . implode('-', $this->selectedCustomers) . '-' . $this->selectedState);
        if ($stateSalesData === false) {
            try {
                $connection = Yii::app()->db;
                $connection->active = true;
                $sql =
                    "SELECT " .
                    "if(SUM(if(bi2_usage.bi2_month BETWEEN 1 AND 6, bi2_usage.bi2_value, 0))>0, SUM(if(bi2_usage.bi2_month BETWEEN 7 AND 12, bi2_usage.bi2_value, 0))/SUM(if(bi2_usage.bi2_month BETWEEN 1 AND 6, bi2_usage.bi2_value, 0))*100, 100) AS trend, " .
                    "fa1_facility.cu1_id AS id, " .
                    "cu1_customer.cu1_type, " .
                    "cu1_customer.cu1_code, " .
                    "cu1_customer.cu1_name, " .
                    "fa1_facility.st1_id, " .
                    "st1_state.st1_code, " .
                    "st1_state.st1_name, " .
                    "SUM(bi2_usage.bi2_qty) AS total_qty, " .
                    "SUM(bi2_usage.bi2_hit) AS total_hit, " .
                    "ROUND(SUM(bi2_usage.bi2_value), 2) AS total_value " .
                    "FROM bi2_usage " .
                    "LEFT JOIN bi1_bin ON (bi1_bin.id=bi2_usage.bi1_id) " .
                    "LEFT JOIN it1_item ON (it1_item.id=bi1_bin.it1_id) " .
                    "LEFT JOIN lo1_location ON (lo1_location.id=it1_item.lo1_id) " .
                    "LEFT JOIN fa1_facility ON (fa1_facility.id=lo1_location.fa1_id) " .
                    "LEFT JOIN cu1_customer ON (cu1_customer.id=fa1_facility.cu1_id) " .
                    "LEFT JOIN st1_state ON (st1_state.id=fa1_facility.st1_id) " .
                    "WHERE " .
                    "(bi2_usage.bi2_year=:selectedYear) AND " .
                    ($this->selectedCustomers && count($this->selectedCustomers) > 0 ? "(fa1_facility.cu1_id IN (" . implode(',', $this->selectedCustomers) . ")) AND " : "") .
                    ($this->selectedState > 0 ? "(fa1_facility.st1_id=:selectedState) AND " : "") .
                    "(bi2_usage.delete_flag=0) " .
                    "GROUP BY fa1_facility.cu1_id " .
                    "ORDER BY " .
                    ($this->selectedType == self::TYPE_QUANTITY ? 'total_qty' : ($this->selectedType == self::TYPE_HIT ? 'total_hit' : 'total_value')) . " DESC";
                $command = $connection->createCommand($sql);
                $command->bindParam(":selectedYear", $this->selectedYear, PDO::PARAM_INT);
                if ($this->selectedState > 0)
                    $command->bindParam(":selectedState", $this->selectedState, PDO::PARAM_INT);
                $dataReader = $command->query();
                $rows = $dataReader->readAll();
                $connection->active = false;
                // Data
                if ($rows === null) {
                    $rows = array();
                } elseif (Yii::app()->params['dashboardShowRandomTrend']) {
                    $len = count($rows);
                    for ($i = 0; $i < $len; $i++) {
                        $rows[$i]['trend'] = rand(0, 200);
                    }
                }
                $stateSalesData = new CArrayDataProvider($rows, array(
                    'id' => 'id',
                    'sort' => array(
                        'attributes' => array(
                            'total_value',
                            'total_qty',
                            'total_hit',
                        ),
                        'defaultOrder' => array(
                            ($this->selectedType == self::TYPE_QUANTITY ? 'total_qty' : ($this->selectedType == self::TYPE_HIT ? 'total_hit' : 'total_value')) => CSort::SORT_DESC
                        ),
                    ),
                    'pagination' => array(
                        'pageSize' => count($rows),
                    ),
                ));
                // Cache
                Yii::app()->cache->set(
                    'stateSalesData-' . $this->selectedYear . '-' . $this->selectedType . '-' . implode('-', $this->selectedCustomers) . '-' . $this->selectedState, $stateSalesData, Yii::app()->params['dashboardStateSalesDataCacheDuration']);
            } catch (Exception $ex) {
                $ex->getMessage();
            }
        }
        return $stateSalesData;
    }

    ////////////////////////////////////////////////////////////////////////////
    // Customer
    /**
     * Returns the customer's sales data by facility.
     * @return array
     */
    public function getCustomerPieChartData()
    {
        $customerPieChartData = Yii::app()->cache->get(
            'customerPieChartData-' . $this->selectedYear . '-' . $this->selectedType . '-' . implode('-', $this->selectedCustomers) . '-' . $this->selectedState);
        if ($customerPieChartData === false) {
            try {
                $connection = Yii::app()->db;
                $connection->active = true;
                $sql =
                    "SELECT " .
                    "lo1_location.fa1_id, " .
                    "fa1_facility.fa1_name, " .
                    "fa1_facility.cu1_id AS cu1_id, " .
                    "cu1_customer.cu1_code, " .
                    "cu1_customer.cu1_name, " .
                    "fa1_facility.st1_id, " .
                    "st1_state.st1_code, " .
                    "st1_state.st1_name, " .
                    "COUNT(DISTINCT it1_item.lo1_id) AS locations, " .
                    "COUNT(DISTINCT bi1_bin.it1_id) AS items, " .
                    "SUM(bi2_usage.bi2_qty) AS qty, " .
                    "SUM(bi2_usage.bi2_hit) AS hit, " .
                    "ROUND(SUM(bi2_usage.bi2_value), 2) AS dollar " .
                    "FROM bi2_usage " .
                    "LEFT JOIN bi1_bin ON (bi1_bin.id=bi2_usage.bi1_id) " .
                    "LEFT JOIN it1_item ON (it1_item.id=bi1_bin.it1_id) " .
                    "LEFT JOIN lo1_location ON (lo1_location.id=it1_item.lo1_id) " .
                    "LEFT JOIN fa1_facility ON (fa1_facility.id=lo1_location.fa1_id) " .
                    "LEFT JOIN cu1_customer ON (cu1_customer.id=fa1_facility.cu1_id) " .
                    "LEFT JOIN st1_state ON (st1_state.id=fa1_facility.st1_id) " .
                    "WHERE " .
                    "(bi2_usage.bi2_year=:selectedYear) AND " .
                    "(fa1_facility.cu1_id IN (" . implode(',', $this->selectedCustomers) . ")) AND " .
                    ($this->selectedState > 0 ? "(fa1_facility.st1_id=:selectedState) AND " : "") .
                    "(bi2_usage.delete_flag=0) " .
                    "GROUP BY " .
                    "fa1_facility.cu1_id, lo1_location.fa1_id";
                $command = $connection->createCommand($sql);
                $command->bindParam(":selectedYear", $this->selectedYear, PDO::PARAM_INT);
                if ($this->selectedState > 0)
                    $command->bindParam(":selectedState", $this->selectedState, PDO::PARAM_INT);
                $dataReader = $command->query();
                $rows = $dataReader->readAll();
                if (is_null($rows))
                    $rows = array();
                $connection->active = false;
                // Data
                $len = count($rows);
                $total = 0;
                $total_value = 0;
                $total_qty = 0;
                $total_hit = 0;
                $data = array();
                for ($i = 0; $i < $len; $i++) {
                    $row = $rows[$i];
                    // Total Value
                    $total_value += (double) $row['dollar'];
                    $total_qty += (int) $row['qty'];
                    $total_hit += (int) $row['hit'];
                    // Facility Data
                    $data[$row['fa1_id']] = array();
                    $data[$row['fa1_id']]['name'] = $row['fa1_name'];
                    if ($this->selectedType == self::TYPE_QUANTITY) {
                        $total += (int) $row['qty'];
                        $data[$row['fa1_id']]['y'] = (int) $row['qty'];
                    } elseif ($this->selectedType == self::TYPE_HIT) {
                        $total += (int) $row['hit'];
                        $data[$row['fa1_id']]['y'] = (int) $row['hit'];
                    } else {
                        $total += (double) $row['dollar'];
                        $data[$row['fa1_id']]['y'] = (double) $row['dollar'];
                    }
                    if ($this->selectedState > 0) {
                        $data[$row['fa1_id']]['st1_id'] = $row['st1_id'];
                        $data[$row['fa1_id']]['st1_code'] = $row['st1_code'];
                        $data[$row['fa1_id']]['st1_name'] = $row['st1_name'];
                    } else {
                        $data[$row['fa1_id']]['st1_id'] = '';
                        $data[$row['fa1_id']]['st1_code'] = '';
                        $data[$row['fa1_id']]['st1_name'] = '';
                    }
                    $data[$row['fa1_id']]['cu1_id'] = $row['cu1_id'];
                    $data[$row['fa1_id']]['cu1_code'] = $row['cu1_code'];
                    $data[$row['fa1_id']]['cu1_name'] = $row['cu1_name'];
                    $data[$row['fa1_id']]['fa1_id'] = $row['fa1_id'];
                    $data[$row['fa1_id']]['fa1_name'] = $row['fa1_name'];
                    $data[$row['fa1_id']]['locations'] = (int) $row['locations'];
                    $data[$row['fa1_id']]['items'] = (int) $row['items'];
                    $data[$row['fa1_id']]['qty'] = (int) $row['qty'];
                    $data[$row['fa1_id']]['hit'] = (int) $row['hit'];
                    $data[$row['fa1_id']]['dollar'] = (double) $row['dollar'];
                }
                // JSON Data
                $facilityData = array();
                foreach ($data as $facility) {
                    $facilityData[] = array(
                        'name' => $facility['name'],
                        'y' => round($facility['y'] / $total * 100, 1),
                        'st1_id' => $facility['st1_id'],
                        'st1_code' => $facility['st1_code'],
                        'st1_name' => $facility['st1_name'],
                        'cu1_id' => $facility['cu1_id'],
                        'cu1_code' => $facility['cu1_code'],
                        'cu1_name' => $facility['cu1_name'],
                        'fa1_id' => $facility['fa1_id'],
                        'fa1_name' => $facility['fa1_name'],
                        'locations' => $facility['locations'],
                        'items' => $facility['items'],
                        'qty' => $facility['qty'],
                        'hit' => $facility['hit'],
                        'dollar' => $facility['dollar'],
                    );
                }
                $customerPieChartData = array(
                    'facilityData' => $facilityData,
                    'value' => $total_value,
                    'qty' => $total_qty,
                    'hit' => $total_hit,
                );
                // Cache
                Yii::app()->cache->set(
                    'customerPieChartData-' . $this->selectedYear . '-' . $this->selectedType . '-' . implode('-', $this->selectedCustomers) . '-' . $this->selectedState, $customerPieChartData, Yii::app()->params['dashboardCustomerPieChartDataCacheDuration']);
            } catch (Exception $ex) {
                $ex->getMessage();
            }
        }
        return $customerPieChartData;
    }

    /**
     * Returns the customer's sales data by facility.
     * @return CArrayDataProvider
     */
    public function getCustomerSalesData()
    {
        $customerSalesData = Yii::app()->cache->get(
            'customerSalesData-' . $this->selectedYear . '-' . $this->selectedType . '-' . implode('-', $this->selectedCustomers) . '-' . $this->selectedState);
        if ($customerSalesData === false) {
            try {
                $connection = Yii::app()->db;
                $connection->active = true;
                $sql =
                    "SELECT " .
                    "if(SUM(if(bi2_usage.bi2_month BETWEEN 1 AND 6, bi2_usage.bi2_value, 0))>0, SUM(if(bi2_usage.bi2_month BETWEEN 7 AND 12, bi2_usage.bi2_value, 0))/SUM(if(bi2_usage.bi2_month BETWEEN 1 AND 6, bi2_usage.bi2_value, 0))*100, 100) AS trend, " .
                    "lo1_location.fa1_id AS id, " .
                    "fa1_facility.fa1_name, " .
                    "fa1_facility.cu1_id, " .
                    "cu1_customer.cu1_type, " .
                    "cu1_customer.cu1_code, " .
                    "cu1_customer.cu1_name, " .
                    "fa1_facility.st1_id, " .
                    "st1_state.st1_code, " .
                    "st1_state.st1_name, " .
                    "SUM(bi2_usage.bi2_qty) AS total_qty, " .
                    "SUM(bi2_usage.bi2_hit) AS total_hit, " .
                    "ROUND(SUM(bi2_usage.bi2_value), 2) AS total_value " .
                    "FROM bi2_usage " .
                    "LEFT JOIN bi1_bin ON (bi1_bin.id=bi2_usage.bi1_id) " .
                    "LEFT JOIN it1_item ON (it1_item.id=bi1_bin.it1_id) " .
                    "LEFT JOIN lo1_location ON (lo1_location.id=it1_item.lo1_id) " .
                    "LEFT JOIN fa1_facility ON (fa1_facility.id=lo1_location.fa1_id) " .
                    "LEFT JOIN cu1_customer ON (cu1_customer.id=fa1_facility.cu1_id) " .
                    "LEFT JOIN st1_state ON (st1_state.id=fa1_facility.st1_id) " .
                    "WHERE " .
                    "(bi2_usage.bi2_year=:selectedYear) AND " .
                    "(fa1_facility.cu1_id IN (" . implode(',', $this->selectedCustomers) . ")) AND " .
                    ($this->selectedState > 0 ? "(fa1_facility.st1_id=:selectedState) AND " : "") .
                    "(bi2_usage.delete_flag=0) " .
                    "GROUP BY " .
                    "fa1_facility.cu1_id, lo1_location.fa1_id " .
                    "ORDER BY " .
                    ($this->selectedType == self::TYPE_QUANTITY ? 'total_qty' : ($this->selectedType == self::TYPE_HIT ? 'total_hit' : 'total_value')) . " DESC";
                $command = $connection->createCommand($sql);
                $command->bindParam(":selectedYear", $this->selectedYear, PDO::PARAM_INT);
                if ($this->selectedState > 0)
                    $command->bindParam(":selectedState", $this->selectedState, PDO::PARAM_INT);
                $dataReader = $command->query();
                $rows = $dataReader->readAll();
                $connection->active = false;
                // Data
                if ($rows === null) {
                    $rows = array();
                } elseif (Yii::app()->params['dashboardShowRandomTrend']) {
                    $len = count($rows);
                    for ($i = 0; $i < $len; $i++) {
                        $rows[$i]['trend'] = rand(0, 200);
                    }
                }
                $customerSalesData = new CArrayDataProvider($rows, array(
                    'id' => 'id',
                    'sort' => array(
                        'attributes' => array(
                            'total_value',
                            'total_qty',
                            'total_hit',
                        ),
                        'defaultOrder' => array(
                            ($this->selectedType == self::TYPE_QUANTITY ? 'total_qty' : ($this->selectedType == self::TYPE_HIT ? 'total_hit' : 'total_value')) => CSort::SORT_DESC
                        ),
                    ),
                    'pagination' => array(
                        'pageSize' => count($rows),
                    ),
                ));
                // Cache
                Yii::app()->cache->set(
                    'customerSalesData-' . $this->selectedYear . '-' . $this->selectedType . '-' . implode('-', $this->selectedCustomers) . '-' . $this->selectedState, $customerSalesData, Yii::app()->params['dashboardCustomerSalesDataCacheDuration']);
            } catch (Exception $ex) {
                $ex->getMessage();
            }
        }
        return $customerSalesData;
    }

    /**
     * Returns the customer's sales history.
     * @return array
     */
    public function getCustomerSalesHistory()
    {
        $customerSalesHistory = Yii::app()->cache->get(
            'customerSalesHistory-' . $this->selectedYear . '-' . $this->selectedType . '-' . implode('-', $this->selectedCustomers) . '-' . $this->selectedState);
        if ($customerSalesHistory === false) {
            try {
                $connection = Yii::app()->db;
                $connection->active = true;
                $sql =
                    "SELECT " .
                    "fa1_facility.cu1_id, " .
                    "bi2_usage.bi2_year, " .
                    "COUNT(DISTINCT lo1_location.fa1_id) AS facilities, " .
                    "COUNT(DISTINCT it1_item.lo1_id) AS locations, " .
                    "COUNT(DISTINCT bi1_bin.it1_id) AS items, " .
                    "SUM(bi2_usage.bi2_qty) AS totalQty, " .
                    "SUM(bi2_usage.bi2_hit) AS totalHit, " .
                    "SUM(bi2_usage.bi2_value) AS totalValue, " .
                    "SUM(if(bi2_usage.bi2_month=1,bi2_usage.bi2_qty,0)) AS m1_qty, " .
                    "SUM(if(bi2_usage.bi2_month=1,bi2_usage.bi2_hit,0)) AS m1_hit, " .
                    "SUM(if(bi2_usage.bi2_month=1,bi2_usage.bi2_value,0)) AS m1_value, " .
                    "SUM(if(bi2_usage.bi2_month=2,bi2_usage.bi2_qty,0)) AS m2_qty, " .
                    "SUM(if(bi2_usage.bi2_month=2,bi2_usage.bi2_hit,0)) AS m2_hit, " .
                    "SUM(if(bi2_usage.bi2_month=2,bi2_usage.bi2_value,0)) AS m2_value, " .
                    "SUM(if(bi2_usage.bi2_month=3,bi2_usage.bi2_qty,0)) AS m3_qty, " .
                    "SUM(if(bi2_usage.bi2_month=3,bi2_usage.bi2_hit,0)) AS m3_hit, " .
                    "SUM(if(bi2_usage.bi2_month=3,bi2_usage.bi2_value,0)) AS m3_value, " .
                    "SUM(if(bi2_usage.bi2_month=4,bi2_usage.bi2_qty,0)) AS m4_qty, " .
                    "SUM(if(bi2_usage.bi2_month=4,bi2_usage.bi2_hit,0)) AS m4_hit, " .
                    "SUM(if(bi2_usage.bi2_month=4,bi2_usage.bi2_value,0)) AS m4_value, " .
                    "SUM(if(bi2_usage.bi2_month=5,bi2_usage.bi2_qty,0)) AS m5_qty, " .
                    "SUM(if(bi2_usage.bi2_month=5,bi2_usage.bi2_hit,0)) AS m5_hit, " .
                    "SUM(if(bi2_usage.bi2_month=5,bi2_usage.bi2_value,0)) AS m5_value, " .
                    "SUM(if(bi2_usage.bi2_month=6,bi2_usage.bi2_qty,0)) AS m6_qty, " .
                    "SUM(if(bi2_usage.bi2_month=6,bi2_usage.bi2_hit,0)) AS m6_hit, " .
                    "SUM(if(bi2_usage.bi2_month=6,bi2_usage.bi2_value,0)) AS m6_value, " .
                    "SUM(if(bi2_usage.bi2_month=7,bi2_usage.bi2_qty,0)) AS m7_qty, " .
                    "SUM(if(bi2_usage.bi2_month=7,bi2_usage.bi2_hit,0)) AS m7_hit, " .
                    "SUM(if(bi2_usage.bi2_month=7,bi2_usage.bi2_value,0)) AS m7_value, " .
                    "SUM(if(bi2_usage.bi2_month=8,bi2_usage.bi2_qty,0)) AS m8_qty, " .
                    "SUM(if(bi2_usage.bi2_month=8,bi2_usage.bi2_hit,0)) AS m8_hit, " .
                    "SUM(if(bi2_usage.bi2_month=8,bi2_usage.bi2_value,0)) AS m8_value, " .
                    "SUM(if(bi2_usage.bi2_month=9,bi2_usage.bi2_qty,0)) AS m9_qty, " .
                    "SUM(if(bi2_usage.bi2_month=9,bi2_usage.bi2_hit,0)) AS m9_hit, " .
                    "SUM(if(bi2_usage.bi2_month=9,bi2_usage.bi2_value,0)) AS m9_value, " .
                    "SUM(if(bi2_usage.bi2_month=10,bi2_usage.bi2_qty,0)) AS m10_qty, " .
                    "SUM(if(bi2_usage.bi2_month=10,bi2_usage.bi2_hit,0)) AS m10_hit, " .
                    "SUM(if(bi2_usage.bi2_month=10,bi2_usage.bi2_value,0)) AS m10_value, " .
                    "SUM(if(bi2_usage.bi2_month=11,bi2_usage.bi2_qty,0)) AS m11_qty, " .
                    "SUM(if(bi2_usage.bi2_month=11,bi2_usage.bi2_hit,0)) AS m11_hit, " .
                    "SUM(if(bi2_usage.bi2_month=11,bi2_usage.bi2_value,0)) AS m11_value, " .
                    "SUM(if(bi2_usage.bi2_month=12,bi2_usage.bi2_qty,0)) AS m12_qty, " .
                    "SUM(if(bi2_usage.bi2_month=12,bi2_usage.bi2_hit,0)) AS m12_hit, " .
                    "SUM(if(bi2_usage.bi2_month=12,bi2_usage.bi2_value,0)) AS m12_value " .
                    "FROM bi2_usage " .
                    "LEFT JOIN bi1_bin ON (bi1_bin.id=bi2_usage.bi1_id) " .
                    "LEFT JOIN it1_item ON (it1_item.id=bi1_bin.it1_id) " .
                    "LEFT JOIN lo1_location ON (lo1_location.id=it1_item.lo1_id) " .
                    "LEFT JOIN fa1_facility ON (fa1_facility.id=lo1_location.fa1_id) " .
                    "WHERE " .
                    "(bi2_usage.bi2_year=:selectedYear) AND " .
                    "(fa1_facility.cu1_id IN (" . implode(',', $this->selectedCustomers) . ")) AND " .
                    ($this->selectedState > 0 ? "(fa1_facility.st1_id=:selectedState) AND " : "") .
                    "(bi2_usage.delete_flag=0) " .
                    "GROUP BY " .
                    "fa1_facility.cu1_id, bi2_usage.bi2_year";
                $command = $connection->createCommand($sql);
                $command->bindParam(":selectedYear", $this->selectedYear, PDO::PARAM_INT);
                if ($this->selectedState > 0)
                    $command->bindParam(":selectedState", $this->selectedState, PDO::PARAM_INT);
                $dataReader = $command->query();
                $rows = $dataReader->readAll();
                if ($rows === null) {
                    $rows = array();
                }
                $connection->active = false;
                if (count($rows) == 1) {
                    // Data
                    $customerSalesHistory = array(
                        'facilities' => (int) $rows[0]['facilities'],
                        'locations' => (int) $rows[0]['locations'],
                        'items' => (int) $rows[0]['items'],
                        'totalValue' => (double) $rows[0]['totalValue'],
                        'totalQty' => (int) $rows[0]['totalQty'],
                        'totalHit' => (int) $rows[0]['totalHit'],
                        'saleValue' => array(),
                        'salesQuantity' => array(),
                        'orderCount' => array(),
                        'averageValue' => array(),
                    );
                    for ($m = 1; $m <= 12; $m++) {
                        $customerSalesHistory['saleValue'][] = (double) $rows[0]["m{$m}_value"];
                        $customerSalesHistory['salesQuantity'][] = (int) $rows[0]["m{$m}_qty"];
                        $customerSalesHistory['orderCount'][] = (int) $rows[0]["m{$m}_hit"];
                        if ((int) $rows[0]["m{$m}_hit"] > 0) {
                            $customerSalesHistory['averageValue'][] = (double) $rows[0]["m{$m}_value"] / (int) $rows[0]["m{$m}_hit"];
                        } else {
                            $customerSalesHistory['averageValue'][] = 0;
                        }
                    }
                    // Cache
                    Yii::app()->cache->set(
                        'customerSalesHistory-' . $this->selectedYear . '-' . $this->selectedType . '-' . implode('-', $this->selectedCustomers) . '-' . $this->selectedState, $customerSalesHistory, Yii::app()->params['dashboardCustomerSalesHistoryCacheDuration']);
                } else {
                    $customerSalesHistory = array(
                        'facilities' => 0,
                        'locations' => 0,
                        'items' => 0,
                        'totalValue' => 0,
                        'totalQty' => 0,
                        'totalHit' => 0,
                        'saleValue' => array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
                        'salesQuantity' => array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
                        'orderCount' => array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
                        'averageValue' => array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
                    );
                }
            } catch (Exception $ex) {
                $ex->getMessage();
            }
        }
        return $customerSalesHistory;
    }

    ////////////////////////////////////////////////////////////////////////////
    // Facility
    /**
     * Returns the facility's sales data by location.
     * @return array
     */
    public function getFacilityPieChartData()
    {
        $facilityPieChartData = Yii::app()->cache->get(
            'facilityPieChartData-' . $this->selectedYear . '-' . $this->selectedType . '-' . implode('-', $this->selectedCustomers) . '-' . $this->selectedFacility);
        if ($facilityPieChartData === false) {
            try {
                $connection = Yii::app()->db;
                $connection->active = true;
                $sql =
                    "SELECT " .
                    "it1_item.lo1_id, " .
                    "lo1_location.lo1_code, " .
                    "lo1_location.lo1_name, " .
                    "lo1_location.fa1_id, " .
                    "fa1_facility.fa1_name, " .
                    "fa1_facility.cu1_id AS cu1_id, " .
                    "cu1_customer.cu1_code, " .
                    "cu1_customer.cu1_name, " .
                    "fa1_facility.st1_id, " .
                    "st1_state.st1_code, " .
                    "st1_state.st1_name, " .
                    "COUNT(DISTINCT bi1_bin.it1_id) AS items, " .
                    "SUM(bi2_usage.bi2_qty) AS qty, " .
                    "SUM(bi2_usage.bi2_hit) AS hit, " .
                    "ROUND(SUM(bi2_usage.bi2_value), 2) AS dollar " .
                    "FROM bi2_usage " .
                    "LEFT JOIN bi1_bin ON (bi1_bin.id=bi2_usage.bi1_id) " .
                    "LEFT JOIN it1_item ON (it1_item.id=bi1_bin.it1_id) " .
                    "LEFT JOIN lo1_location ON (lo1_location.id=it1_item.lo1_id) " .
                    "LEFT JOIN fa1_facility ON (fa1_facility.id=lo1_location.fa1_id) " .
                    "LEFT JOIN cu1_customer ON (cu1_customer.id=fa1_facility.cu1_id) " .
                    "LEFT JOIN st1_state ON (st1_state.id=fa1_facility.st1_id) " .
                    "WHERE " .
                    "(bi2_usage.bi2_year=:selectedYear) AND " .
                    "(lo1_location.fa1_id=:selectedFacility) AND " .
                    "(fa1_facility.cu1_id IN (" . implode(',', $this->selectedCustomers) . ")) AND " .
                    "(bi2_usage.delete_flag=0) " .
                    "GROUP BY " .
                    "fa1_facility.cu1_id, lo1_location.fa1_id, it1_item.lo1_id";
                $command = $connection->createCommand($sql);
                $command->bindParam(":selectedYear", $this->selectedYear, PDO::PARAM_INT);
                $command->bindParam(":selectedFacility", $this->selectedFacility, PDO::PARAM_INT);
                $dataReader = $command->query();
                $rows = $dataReader->readAll();
                if (is_null($rows))
                    $rows = array();
                $connection->active = false;
                // Data
                $len = count($rows);
                $total = 0;
                $total_value = 0;
                $total_qty = 0;
                $total_hit = 0;
                $data = array();
                for ($i = 0; $i < $len; $i++) {
                    $row = $rows[$i];
                    // Total Value
                    $total_value += (double) $row['dollar'];
                    $total_qty += (int) $row['qty'];
                    $total_hit += (int) $row['hit'];
                    // Location Data
                    $data[$row['lo1_id']] = array();
                    $data[$row['lo1_id']]['name'] = $row['lo1_name'];
                    if ($this->selectedType == self::TYPE_QUANTITY) {
                        $total += (int) $row['qty'];
                        $data[$row['lo1_id']]['y'] = (int) $row['qty'];
                    } elseif ($this->selectedType == self::TYPE_HIT) {
                        $total += (int) $row['hit'];
                        $data[$row['lo1_id']]['y'] = (int) $row['hit'];
                    } else {
                        $total += (double) $row['dollar'];
                        $data[$row['lo1_id']]['y'] = (double) $row['dollar'];
                    }
                    if ($this->selectedState > 0) {
                        $data[$row['lo1_id']]['st1_id'] = $row['st1_id'];
                        $data[$row['lo1_id']]['st1_code'] = $row['st1_code'];
                        $data[$row['lo1_id']]['st1_name'] = $row['st1_name'];
                    } else {
                        $data[$row['lo1_id']]['st1_id'] = '';
                        $data[$row['lo1_id']]['st1_code'] = '';
                        $data[$row['lo1_id']]['st1_name'] = '';
                    }
                    $data[$row['lo1_id']]['cu1_id'] = $row['cu1_id'];
                    $data[$row['lo1_id']]['cu1_code'] = $row['cu1_code'];
                    $data[$row['lo1_id']]['cu1_name'] = $row['cu1_name'];
                    $data[$row['lo1_id']]['fa1_id'] = $row['fa1_id'];
                    $data[$row['lo1_id']]['fa1_name'] = $row['fa1_name'];
                    $data[$row['lo1_id']]['lo1_id'] = $row['lo1_id'];
                    $data[$row['lo1_id']]['lo1_code'] = $row['lo1_code'];
                    $data[$row['lo1_id']]['lo1_name'] = $row['lo1_name'];
                    $data[$row['lo1_id']]['items'] = (int) $row['items'];
                    $data[$row['lo1_id']]['qty'] = (int) $row['qty'];
                    $data[$row['lo1_id']]['hit'] = (int) $row['hit'];
                    $data[$row['lo1_id']]['dollar'] = (double) $row['dollar'];
                }
                // JSON Data
                $locationData = array();
                foreach ($data as $location) {
                    $locationData[] = array(
                        'name' => $location['name'],
                        'y' => round($location['y'] / $total * 100, 1),
                        'st1_id' => $location['st1_id'],
                        'st1_code' => $location['st1_code'],
                        'st1_name' => $location['st1_name'],
                        'cu1_id' => $location['cu1_id'],
                        'cu1_code' => $location['cu1_code'],
                        'cu1_name' => $location['cu1_name'],
                        'fa1_id' => $location['fa1_id'],
                        'fa1_name' => $location['fa1_name'],
                        'lo1_id' => $location['lo1_id'],
                        'lo1_code' => $location['lo1_code'],
                        'lo1_name' => $location['lo1_name'],
                        'items' => $location['items'],
                        'qty' => $location['qty'],
                        'hit' => $location['hit'],
                        'dollar' => $location['dollar'],
                    );
                }
                $facilityPieChartData = array(
                    'locationData' => $locationData,
                    'value' => $total_value,
                    'qty' => $total_qty,
                    'hit' => $total_hit,
                );
                // Cache
                Yii::app()->cache->set(
                    'facilityPieChartData-' . $this->selectedYear . '-' . $this->selectedType . '-' . implode('-', $this->selectedCustomers) . '-' . $this->selectedFacility, $facilityPieChartData, Yii::app()->params['dashboardFacilityPieChartDataCacheDuration']);
            } catch (Exception $ex) {
                $ex->getMessage();
            }
        }
        return $facilityPieChartData;
    }

    /**
     * Returns the facility's sales data by location.
     * @return CArrayDataProvider
     */
    public function getFacilitySalesData()
    {
        $facilitySalesData = Yii::app()->cache->get(
            'facilitySalesData-' . $this->selectedYear . '-' . $this->selectedType . '-' . implode('-', $this->selectedCustomers) . '-' . $this->selectedFacility);
        if ($facilitySalesData === false) {
            try {
                $connection = Yii::app()->db;
                $connection->active = true;
                $sql =
                    "SELECT " .
                    "if(SUM(if(bi2_usage.bi2_month BETWEEN 1 AND 6, bi2_usage.bi2_value, 0))>0, SUM(if(bi2_usage.bi2_month BETWEEN 7 AND 12, bi2_usage.bi2_value, 0))/SUM(if(bi2_usage.bi2_month BETWEEN 1 AND 6, bi2_usage.bi2_value, 0))*100, 100) AS trend, " .
                    "it1_item.lo1_id AS id, " .
                    "lo1_location.lo1_code, " .
                    "lo1_location.lo1_name, " .
                    "lo1_location.fa1_id, " .
                    "fa1_facility.fa1_name, " .
                    "fa1_facility.cu1_id, " .
                    "cu1_customer.cu1_type, " .
                    "cu1_customer.cu1_code, " .
                    "cu1_customer.cu1_name, " .
                    "fa1_facility.st1_id, " .
                    "st1_state.st1_code, " .
                    "st1_state.st1_name, " .
                    "SUM(bi2_usage.bi2_qty) AS total_qty, " .
                    "SUM(bi2_usage.bi2_hit) AS total_hit, " .
                    "ROUND(SUM(bi2_usage.bi2_value), 2) AS total_value " .
                    "FROM bi2_usage " .
                    "LEFT JOIN bi1_bin ON (bi1_bin.id=bi2_usage.bi1_id) " .
                    "LEFT JOIN it1_item ON (it1_item.id=bi1_bin.it1_id) " .
                    "LEFT JOIN lo1_location ON (lo1_location.id=it1_item.lo1_id) " .
                    "LEFT JOIN fa1_facility ON (fa1_facility.id=lo1_location.fa1_id) " .
                    "LEFT JOIN cu1_customer ON (cu1_customer.id=fa1_facility.cu1_id) " .
                    "LEFT JOIN st1_state ON (st1_state.id=fa1_facility.st1_id) " .
                    "WHERE " .
                    "(bi2_usage.bi2_year=:selectedYear) AND " .
                    "(lo1_location.fa1_id=:selectedFacility) AND " .
                    "(fa1_facility.cu1_id IN (" . implode(',', $this->selectedCustomers) . ")) AND " .
                    "(bi2_usage.delete_flag=0) " .
                    "GROUP BY " .
                    "fa1_facility.cu1_id, lo1_location.fa1_id, it1_item.lo1_id " .
                    "ORDER BY " .
                    ($this->selectedType == self::TYPE_QUANTITY ? 'total_qty' : ($this->selectedType == self::TYPE_HIT ? 'total_hit' : 'total_value')) . " DESC";
                $command = $connection->createCommand($sql);
                $command->bindParam(":selectedYear", $this->selectedYear, PDO::PARAM_INT);
                $command->bindParam(":selectedFacility", $this->selectedFacility, PDO::PARAM_INT);
                $dataReader = $command->query();
                $rows = $dataReader->readAll();
                $connection->active = false;
                // Data
                if ($rows === null) {
                    $rows = array();
                } elseif (Yii::app()->params['dashboardShowRandomTrend']) {
                    $len = count($rows);
                    for ($i = 0; $i < $len; $i++) {
                        $rows[$i]['trend'] = rand(0, 200);
                    }
                }
                $facilitySalesData = new CArrayDataProvider($rows, array(
                    'id' => 'id',
                    'sort' => array(
                        'attributes' => array(
                            'total_value',
                            'total_qty',
                            'total_hit',
                        ),
                        'defaultOrder' => array(
                            ($this->selectedType == self::TYPE_QUANTITY ? 'total_qty' : ($this->selectedType == self::TYPE_HIT ? 'total_hit' : 'total_value')) => CSort::SORT_DESC
                        ),
                    ),
                    'pagination' => array(
                        'pageSize' => count($rows),
                    ),
                ));
                // Cache
                Yii::app()->cache->set(
                    'facilitySalesData-' . $this->selectedYear . '-' . $this->selectedType . '-' . implode('-', $this->selectedCustomers) . '-' . $this->selectedFacility, $facilitySalesData, Yii::app()->params['dashboardFacilitySalesDataCacheDuration']);
            } catch (Exception $ex) {
                $ex->getMessage();
            }
        }
        return $facilitySalesData;
    }

    /**
     * Returns the facility's sales history.
     * @return array
     */
    public function getFacilitySalesHistory()
    {
        $facilitySalesHistory = Yii::app()->cache->get(
            'facilitySalesHistory-' . $this->selectedYear . '-' . $this->selectedType . '-' . implode('-', $this->selectedCustomers) . '-' . $this->selectedFacility);
        if ($facilitySalesHistory === false) {
            try {
                $connection = Yii::app()->db;
                $connection->active = true;
                $sql =
                    "SELECT " .
                    "fa1_facility.cu1_id, " .
                    "lo1_location.fa1_id, " .
                    "bi2_usage.bi2_year, " .
                    "COUNT(DISTINCT it1_item.lo1_id) AS locations, " .
                    "COUNT(DISTINCT bi1_bin.it1_id) AS items, " .
                    "SUM(bi2_usage.bi2_qty) AS totalQty, " .
                    "SUM(bi2_usage.bi2_hit) AS totalHit, " .
                    "SUM(bi2_usage.bi2_value) AS totalValue, " .
                    "SUM(if(bi2_usage.bi2_month=1,bi2_usage.bi2_qty,0)) AS m1_qty, " .
                    "SUM(if(bi2_usage.bi2_month=1,bi2_usage.bi2_hit,0)) AS m1_hit, " .
                    "SUM(if(bi2_usage.bi2_month=1,bi2_usage.bi2_value,0)) AS m1_value, " .
                    "SUM(if(bi2_usage.bi2_month=2,bi2_usage.bi2_qty,0)) AS m2_qty, " .
                    "SUM(if(bi2_usage.bi2_month=2,bi2_usage.bi2_hit,0)) AS m2_hit, " .
                    "SUM(if(bi2_usage.bi2_month=2,bi2_usage.bi2_value,0)) AS m2_value, " .
                    "SUM(if(bi2_usage.bi2_month=3,bi2_usage.bi2_qty,0)) AS m3_qty, " .
                    "SUM(if(bi2_usage.bi2_month=3,bi2_usage.bi2_hit,0)) AS m3_hit, " .
                    "SUM(if(bi2_usage.bi2_month=3,bi2_usage.bi2_value,0)) AS m3_value, " .
                    "SUM(if(bi2_usage.bi2_month=4,bi2_usage.bi2_qty,0)) AS m4_qty, " .
                    "SUM(if(bi2_usage.bi2_month=4,bi2_usage.bi2_hit,0)) AS m4_hit, " .
                    "SUM(if(bi2_usage.bi2_month=4,bi2_usage.bi2_value,0)) AS m4_value, " .
                    "SUM(if(bi2_usage.bi2_month=5,bi2_usage.bi2_qty,0)) AS m5_qty, " .
                    "SUM(if(bi2_usage.bi2_month=5,bi2_usage.bi2_hit,0)) AS m5_hit, " .
                    "SUM(if(bi2_usage.bi2_month=5,bi2_usage.bi2_value,0)) AS m5_value, " .
                    "SUM(if(bi2_usage.bi2_month=6,bi2_usage.bi2_qty,0)) AS m6_qty, " .
                    "SUM(if(bi2_usage.bi2_month=6,bi2_usage.bi2_hit,0)) AS m6_hit, " .
                    "SUM(if(bi2_usage.bi2_month=6,bi2_usage.bi2_value,0)) AS m6_value, " .
                    "SUM(if(bi2_usage.bi2_month=7,bi2_usage.bi2_qty,0)) AS m7_qty, " .
                    "SUM(if(bi2_usage.bi2_month=7,bi2_usage.bi2_hit,0)) AS m7_hit, " .
                    "SUM(if(bi2_usage.bi2_month=7,bi2_usage.bi2_value,0)) AS m7_value, " .
                    "SUM(if(bi2_usage.bi2_month=8,bi2_usage.bi2_qty,0)) AS m8_qty, " .
                    "SUM(if(bi2_usage.bi2_month=8,bi2_usage.bi2_hit,0)) AS m8_hit, " .
                    "SUM(if(bi2_usage.bi2_month=8,bi2_usage.bi2_value,0)) AS m8_value, " .
                    "SUM(if(bi2_usage.bi2_month=9,bi2_usage.bi2_qty,0)) AS m9_qty, " .
                    "SUM(if(bi2_usage.bi2_month=9,bi2_usage.bi2_hit,0)) AS m9_hit, " .
                    "SUM(if(bi2_usage.bi2_month=9,bi2_usage.bi2_value,0)) AS m9_value, " .
                    "SUM(if(bi2_usage.bi2_month=10,bi2_usage.bi2_qty,0)) AS m10_qty, " .
                    "SUM(if(bi2_usage.bi2_month=10,bi2_usage.bi2_hit,0)) AS m10_hit, " .
                    "SUM(if(bi2_usage.bi2_month=10,bi2_usage.bi2_value,0)) AS m10_value, " .
                    "SUM(if(bi2_usage.bi2_month=11,bi2_usage.bi2_qty,0)) AS m11_qty, " .
                    "SUM(if(bi2_usage.bi2_month=11,bi2_usage.bi2_hit,0)) AS m11_hit, " .
                    "SUM(if(bi2_usage.bi2_month=11,bi2_usage.bi2_value,0)) AS m11_value, " .
                    "SUM(if(bi2_usage.bi2_month=12,bi2_usage.bi2_qty,0)) AS m12_qty, " .
                    "SUM(if(bi2_usage.bi2_month=12,bi2_usage.bi2_hit,0)) AS m12_hit, " .
                    "SUM(if(bi2_usage.bi2_month=12,bi2_usage.bi2_value,0)) AS m12_value " .
                    "FROM bi2_usage " .
                    "LEFT JOIN bi1_bin ON (bi1_bin.id=bi2_usage.bi1_id) " .
                    "LEFT JOIN it1_item ON (it1_item.id=bi1_bin.it1_id) " .
                    "LEFT JOIN lo1_location ON (lo1_location.id=it1_item.lo1_id) " .
                    "LEFT JOIN fa1_facility ON (fa1_facility.id=lo1_location.fa1_id) " .
                    "WHERE " .
                    "(bi2_usage.bi2_year=:selectedYear) AND " .
                    "(lo1_location.fa1_id=:selectedFacility) AND " .
                    "(fa1_facility.cu1_id IN (" . implode(',', $this->selectedCustomers) . ")) AND " .
                    "(bi2_usage.delete_flag=0) " .
                    "GROUP BY " .
                    "fa1_facility.cu1_id, lo1_location.fa1_id, bi2_usage.bi2_year";
                $command = $connection->createCommand($sql);
                $command->bindParam(":selectedYear", $this->selectedYear, PDO::PARAM_INT);
                $command->bindParam(":selectedFacility", $this->selectedFacility, PDO::PARAM_INT);
                $dataReader = $command->query();
                $rows = $dataReader->readAll();
                if ($rows === null) {
                    $rows = array();
                }
                $connection->active = false;
                if (count($rows) == 1) {
                    // Data
                    $facilitySalesHistory = array(
                        'locations' => (int) $rows[0]['locations'],
                        'items' => (int) $rows[0]['items'],
                        'totalValue' => (double) $rows[0]['totalValue'],
                        'totalQty' => (int) $rows[0]['totalQty'],
                        'totalHit' => (int) $rows[0]['totalHit'],
                        'saleValue' => array(),
                        'salesQuantity' => array(),
                        'orderCount' => array(),
                        'averageValue' => array(),
                    );
                    for ($m = 1; $m <= 12; $m++) {
                        $facilitySalesHistory['saleValue'][] = (double) $rows[0]["m{$m}_value"];
                        $facilitySalesHistory['salesQuantity'][] = (int) $rows[0]["m{$m}_qty"];
                        $facilitySalesHistory['orderCount'][] = (int) $rows[0]["m{$m}_hit"];
                        if ((int) $rows[0]["m{$m}_hit"] > 0) {
                            $facilitySalesHistory['averageValue'][] = (double) $rows[0]["m{$m}_value"] / (int) $rows[0]["m{$m}_hit"];
                        } else {
                            $facilitySalesHistory['averageValue'][] = 0;
                        }
                    }
                    // Cache
                    Yii::app()->cache->set(
                        'facilitySalesHistory-' . $this->selectedYear . '-' . $this->selectedType . '-' . implode('-', $this->selectedCustomers) . '-' . $this->selectedFacility, $facilitySalesHistory, Yii::app()->params['dashboardFacilitySalesHistoryCacheDuration']);
                } else {
                    $facilitySalesHistory = array(
                        'locations' => 0,
                        'items' => 0,
                        'totalValue' => 0,
                        'totalQty' => 0,
                        'totalHit' => 0,
                        'saleValue' => array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
                        'salesQuantity' => array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
                        'orderCount' => array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
                        'averageValue' => array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
                    );
                }
            } catch (Exception $ex) {
                $ex->getMessage();
            }
        }
        return $facilitySalesHistory;
    }

    ////////////////////////////////////////////////////////////////////////////
    // Location
    /**
     * Returns the location's sales data by item.
     * @return array
     */
    public function getLocationPieChartData()
    {
        $facilityPieChartData = Yii::app()->cache->get(
            'facilityPieChartData-' . $this->selectedYear . '-' . $this->selectedType . '-' . implode('-', $this->selectedCustomers) . '-' . $this->selectedFacility . '-' . $this->selectedLocation);
        if ($facilityPieChartData === false) {
            try {
                $connection = Yii::app()->db;
                $connection->active = true;
                $sql =
                    "SELECT " .
                    "bi1_bin.it1_id AS item_id, " .
                    "it1_item.it1_code AS item_code, " .
                    "it1_item.it1_customer_part_number AS customer_part_number, " .
                    "it1_item.it1_description AS item_description, " .
                    "it1_item.lo1_id, " .
                    "lo1_location.lo1_code, " .
                    "lo1_location.lo1_name, " .
                    "lo1_location.fa1_id, " .
                    "fa1_facility.fa1_name, " .
                    "fa1_facility.cu1_id AS cu1_id, " .
                    "cu1_customer.cu1_code, " .
                    "cu1_customer.cu1_name, " .
                    "fa1_facility.st1_id, " .
                    "st1_state.st1_code, " .
                    "st1_state.st1_name, " .
                    "COUNT(DISTINCT bi2_usage.bi1_id) AS bins, " .
                    "SUM(bi2_usage.bi2_qty) AS qty, " .
                    "SUM(bi2_usage.bi2_hit) AS hit, " .
                    "ROUND(SUM(bi2_usage.bi2_value), 2) AS dollar " .
                    "FROM bi2_usage " .
                    "LEFT JOIN bi1_bin ON (bi1_bin.id=bi2_usage.bi1_id) " .
                    "LEFT JOIN it1_item ON (it1_item.id=bi1_bin.it1_id) " .
                    "LEFT JOIN lo1_location ON (lo1_location.id=it1_item.lo1_id) " .
                    "LEFT JOIN fa1_facility ON (fa1_facility.id=lo1_location.fa1_id) " .
                    "LEFT JOIN cu1_customer ON (cu1_customer.id=fa1_facility.cu1_id) " .
                    "LEFT JOIN st1_state ON (st1_state.id=fa1_facility.st1_id) " .
                    "WHERE " .
                    "(bi2_usage.bi2_year=:selectedYear) AND " .
                    "(it1_item.lo1_id=:selectedLocation) AND " .
                    "(lo1_location.fa1_id=:selectedFacility) AND " .
                    "(fa1_facility.cu1_id IN (" . implode(',', $this->selectedCustomers) . ")) AND " .
                    "(bi2_usage.delete_flag=0) " .
                    "GROUP BY " .
                    "fa1_facility.cu1_id, lo1_location.fa1_id, it1_item.lo1_id, bi1_bin.it1_id " .
                    "ORDER BY " .
                    ($this->selectedType == self::TYPE_QUANTITY ? 'qty' : ($this->selectedType == self::TYPE_HIT ? 'hit' : 'dollar')) . " DESC";
                $command = $connection->createCommand($sql);
                $command->bindParam(":selectedYear", $this->selectedYear, PDO::PARAM_INT);
                $command->bindParam(":selectedLocation", $this->selectedLocation, PDO::PARAM_INT);
                $command->bindParam(":selectedFacility", $this->selectedFacility, PDO::PARAM_INT);
                $dataReader = $command->query();
                $rows = $dataReader->readAll();
                if (is_null($rows))
                    $rows = array();
                $connection->active = false;
                // Data
                $len = count($rows);
                $total = 0;
                $total_value = 0;
                $total_qty = 0;
                $total_hit = 0;
                $data = array();
                for ($i = 0; $i < $len; $i++) {
                    $row = $rows[$i];
                    // Total Value
                    $total_value += (double) $row['dollar'];
                    $total_qty += (int) $row['qty'];
                    $total_hit += (int) $row['hit'];
                    // Item Data
                    $data[$row['item_id']] = array();
                    $data[$row['item_id']]['name'] = $row['item_code'] . ' : ' . $row['item_description'];
                    if ($this->selectedType == self::TYPE_QUANTITY) {
                        $total += (int) $row['qty'];
                        $data[$row['item_id']]['y'] = (int) $row['qty'];
                    } elseif ($this->selectedType == self::TYPE_HIT) {
                        $total += (int) $row['hit'];
                        $data[$row['item_id']]['y'] = (int) $row['hit'];
                    } else {
                        $total += (double) $row['dollar'];
                        $data[$row['item_id']]['y'] = (double) $row['dollar'];
                    }
                    if ($this->selectedState > 0) {
                        $data[$row['item_id']]['st1_id'] = $row['st1_id'];
                        $data[$row['item_id']]['st1_code'] = $row['st1_code'];
                        $data[$row['item_id']]['st1_name'] = $row['st1_name'];
                    } else {
                        $data[$row['item_id']]['st1_id'] = '';
                        $data[$row['item_id']]['st1_code'] = '';
                        $data[$row['item_id']]['st1_name'] = '';
                    }
                    $data[$row['item_id']]['cu1_id'] = $row['cu1_id'];
                    $data[$row['item_id']]['cu1_code'] = $row['cu1_code'];
                    $data[$row['item_id']]['cu1_name'] = $row['cu1_name'];
                    $data[$row['item_id']]['fa1_id'] = $row['fa1_id'];
                    $data[$row['item_id']]['fa1_name'] = $row['fa1_name'];
                    $data[$row['item_id']]['lo1_id'] = $row['lo1_id'];
                    $data[$row['item_id']]['lo1_code'] = $row['lo1_code'];
                    $data[$row['item_id']]['lo1_name'] = $row['lo1_name'];
                    $data[$row['item_id']]['item_id'] = $row['item_id'];
                    $data[$row['item_id']]['item_code'] = $row['item_code'];
                    $data[$row['item_id']]['customer_part_number'] = $row['customer_part_number'];
                    $data[$row['item_id']]['item_description'] = $row['item_description'];
                    $data[$row['item_id']]['bins'] = $row['bins'];
                    $data[$row['item_id']]['qty'] = (int) $row['qty'];
                    $data[$row['item_id']]['hit'] = (int) $row['hit'];
                    $data[$row['item_id']]['dollar'] = (double) $row['dollar'];
                }
                // JSON Data
                $limit = 0;
                $rest = 0;
                $rest_bins = 0;
                $rest_qty = 0;
                $rest_hit = 0;
                $rest_dollar = 0;
                $itemData = array();
                foreach ($data as $item) {
                    $limit++;
                    if ($limit <= (int) Yii::app()->params['dashboardItemLimit']) {
                        $itemData[] = array(
                            'name' => $item['name'],
                            'y' => round($item['y'] / $total * 100, 1),
                            'st1_id' => $item['st1_id'],
                            'st1_code' => $item['st1_code'],
                            'st1_name' => $item['st1_name'],
                            'cu1_id' => $item['cu1_id'],
                            'cu1_code' => $item['cu1_code'],
                            'cu1_name' => $item['cu1_name'],
                            'fa1_id' => $item['fa1_id'],
                            'fa1_name' => $item['fa1_name'],
                            'lo1_id' => $item['lo1_id'],
                            'lo1_code' => $item['lo1_code'],
                            'lo1_name' => $item['lo1_name'],
                            'item_id' => $item['item_id'],
                            'item_code' => $item['item_code'],
                            'customer_part_number' => $item['customer_part_number'],
                            'item_description' => $item['item_description'],
                            'bins' => $item['bins'],
                            'qty' => $item['qty'],
                            'hit' => $item['hit'],
                            'dollar' => $item['dollar'],
                        );
                    } else {
                        $rest += $item['y'];
                        $rest_bins += $item['bins'];
                        $rest_qty += $item['qty'];
                        $rest_hit += $item['hit'];
                        $rest_dollar += $item['dollar'];
                    }
                }
                if ($rest > 0) {
                    $itemData[] = array(
                        'name' => 'Other Items',
                        'y' => round($rest / $total * 100, 1),
                        'st1_id' => $item['st1_id'],
                        'st1_code' => $item['st1_code'],
                        'st1_name' => $item['st1_name'],
                        'cu1_id' => $item['cu1_id'],
                        'cu1_code' => $item['cu1_code'],
                        'cu1_name' => $item['cu1_name'],
                        'fa1_id' => $item['fa1_id'],
                        'fa1_name' => $item['fa1_name'],
                        'lo1_id' => $item['lo1_id'],
                        'lo1_code' => $item['lo1_code'],
                        'lo1_name' => $item['lo1_name'],
                        'item_id' => 0,
                        'item_code' => '',
                        'customer_part_number' => '',
                        'item_description' => '',
                        'bins' => $rest_bins,
                        'qty' => $rest_qty,
                        'hit' => $rest_hit,
                        'dollar' => $rest_dollar,
                    );
                }
                $facilityPieChartData = array(
                    'itemData' => $itemData,
                    'value' => $total_value,
                    'qty' => $total_qty,
                    'hit' => $total_hit,
                );
                // Cache
                Yii::app()->cache->set(
                    'facilityPieChartData-' . $this->selectedYear . '-' . $this->selectedType . '-' . implode('-', $this->selectedCustomers) . '-' . $this->selectedFacility . '-' . $this->selectedLocation, $facilityPieChartData, Yii::app()->params['dashboardLocationPieChartDataCacheDuration']);
            } catch (Exception $ex) {
                $ex->getMessage();
            }
        }
        return $facilityPieChartData;
    }

    /**
     * Returns the location's sales data by item.
     * @return CArrayDataProvider
     */
    public function getLocationSalesData()
    {
        $locationSalesData = Yii::app()->cache->get(
            'locationSalesData-' . $this->selectedYear . '-' . $this->selectedType . '-' . implode('-', $this->selectedCustomers) . '-' . $this->selectedFacility . '-' . $this->selectedLocation);
        if ($locationSalesData === false) {
            try {
                $connection = Yii::app()->db;
                $connection->active = true;
                $sql =
                    "SELECT " .
                    "if(SUM(if(bi2_usage.bi2_month BETWEEN 1 AND 6, bi2_usage.bi2_value, 0))>0, SUM(if(bi2_usage.bi2_month BETWEEN 7 AND 12, bi2_usage.bi2_value, 0))/SUM(if(bi2_usage.bi2_month BETWEEN 1 AND 6, bi2_usage.bi2_value, 0))*100, 100) AS trend, " .
                    "bi1_bin.it1_id AS id, " .
                    "it1_item.it1_code, " .
                    "it1_item.it1_customer_part_number, " .
                    "it1_item.it1_description, " .
                    "it1_item.lo1_id, " .
                    "lo1_location.lo1_code, " .
                    "lo1_location.lo1_name, " .
                    "lo1_location.fa1_id, " .
                    "fa1_facility.fa1_name, " .
                    "fa1_facility.cu1_id, " .
                    "cu1_customer.cu1_type, " .
                    "cu1_customer.cu1_code, " .
                    "cu1_customer.cu1_name, " .
                    "fa1_facility.st1_id, " .
                    "st1_state.st1_code, " .
                    "st1_state.st1_name, " .
                    "SUM(bi2_usage.bi2_qty) AS total_qty, " .
                    "SUM(bi2_usage.bi2_hit) AS total_hit, " .
                    "ROUND(SUM(bi2_usage.bi2_value), 2) AS total_value " .
                    "FROM bi2_usage " .
                    "LEFT JOIN bi1_bin ON (bi1_bin.id=bi2_usage.bi1_id) " .
                    "LEFT JOIN it1_item ON (it1_item.id=bi1_bin.it1_id) " .
                    "LEFT JOIN lo1_location ON (lo1_location.id=it1_item.lo1_id) " .
                    "LEFT JOIN fa1_facility ON (fa1_facility.id=lo1_location.fa1_id) " .
                    "LEFT JOIN cu1_customer ON (cu1_customer.id=fa1_facility.cu1_id) " .
                    "LEFT JOIN st1_state ON (st1_state.id=fa1_facility.st1_id) " .
                    "WHERE " .
                    "(bi2_usage.bi2_year=:selectedYear) AND " .
                    "(it1_item.lo1_id=:selectedLocation) AND " .
                    "(lo1_location.fa1_id=:selectedFacility) AND " .
                    "(fa1_facility.cu1_id IN (" . implode(',', $this->selectedCustomers) . ")) AND " .
                    "(bi2_usage.delete_flag=0) " .
                    "GROUP BY " .
                    "fa1_facility.cu1_id, lo1_location.fa1_id, it1_item.lo1_id, bi1_bin.it1_id " .
                    "ORDER BY " .
                    ($this->selectedType == self::TYPE_QUANTITY ? 'total_qty' : ($this->selectedType == self::TYPE_HIT ? 'total_hit' : 'total_value')) . " DESC";
                $command = $connection->createCommand($sql);
                $command->bindParam(":selectedYear", $this->selectedYear, PDO::PARAM_INT);
                $command->bindParam(":selectedLocation", $this->selectedLocation, PDO::PARAM_INT);
                $command->bindParam(":selectedFacility", $this->selectedFacility, PDO::PARAM_INT);
                $dataReader = $command->query();
                $rows = $dataReader->readAll();
                $connection->active = false;
                // Data
                if ($rows === null) {
                    $rows = array();
                } elseif (Yii::app()->params['dashboardShowRandomTrend']) {
                    $len = count($rows);
                    for ($i = 0; $i < $len; $i++) {
                        $rows[$i]['trend'] = rand(0, 200);
                    }
                }
                $locationSalesData = new CArrayDataProvider($rows, array(
                    'id' => 'id',
                    'sort' => array(
                        'attributes' => array(
                            'total_value',
                            'total_qty',
                            'total_hit',
                        ),
                        'defaultOrder' => array(
                            ($this->selectedType == self::TYPE_QUANTITY ? 'total_qty' : ($this->selectedType == self::TYPE_HIT ? 'total_hit' : 'total_value')) => CSort::SORT_DESC
                        ),
                    ),
                    'pagination' => array(
                        'pageSize' => Yii::app()->params['dashboardItemLimit'],
                    ),
                ));
                // Cache
                Yii::app()->cache->set(
                    'locationSalesData-' . $this->selectedYear . '-' . $this->selectedType . '-' . implode('-', $this->selectedCustomers) . '-' . $this->selectedFacility . '-' . $this->selectedLocation, $locationSalesData, Yii::app()->params['dashboardLocationSalesDataCacheDuration']);
            } catch (Exception $ex) {
                $ex->getMessage();
            }
        }
        return $locationSalesData;
    }

    /**
     * Returns the location's sales history.
     * @return array
     */
    public function getLocationSalesHistory()
    {
        $locationSalesHistory = Yii::app()->cache->get(
            'locationSalesHistory-' . $this->selectedYear . '-' . $this->selectedType . '-' . implode('-', $this->selectedCustomers) . '-' . $this->selectedFacility . '-' . $this->selectedLocation);
        if ($locationSalesHistory === false) {
            try {
                $connection = Yii::app()->db;
                $connection->active = true;
                $sql =
                    "SELECT " .
                    "fa1_facility.cu1_id, " .
                    "lo1_location.fa1_id, " .
                    "it1_item.lo1_id, " .
                    "bi2_usage.bi2_year, " .
                    "COUNT(DISTINCT bi1_bin.it1_id) AS items, " .
                    "SUM(bi2_usage.bi2_qty) AS totalQty, " .
                    "SUM(bi2_usage.bi2_hit) AS totalHit, " .
                    "SUM(bi2_usage.bi2_value) AS totalValue, " .
                    "SUM(if(bi2_usage.bi2_month=1,bi2_usage.bi2_qty,0)) AS m1_qty, " .
                    "SUM(if(bi2_usage.bi2_month=1,bi2_usage.bi2_hit,0)) AS m1_hit, " .
                    "SUM(if(bi2_usage.bi2_month=1,bi2_usage.bi2_value,0)) AS m1_value, " .
                    "SUM(if(bi2_usage.bi2_month=2,bi2_usage.bi2_qty,0)) AS m2_qty, " .
                    "SUM(if(bi2_usage.bi2_month=2,bi2_usage.bi2_hit,0)) AS m2_hit, " .
                    "SUM(if(bi2_usage.bi2_month=2,bi2_usage.bi2_value,0)) AS m2_value, " .
                    "SUM(if(bi2_usage.bi2_month=3,bi2_usage.bi2_qty,0)) AS m3_qty, " .
                    "SUM(if(bi2_usage.bi2_month=3,bi2_usage.bi2_hit,0)) AS m3_hit, " .
                    "SUM(if(bi2_usage.bi2_month=3,bi2_usage.bi2_value,0)) AS m3_value, " .
                    "SUM(if(bi2_usage.bi2_month=4,bi2_usage.bi2_qty,0)) AS m4_qty, " .
                    "SUM(if(bi2_usage.bi2_month=4,bi2_usage.bi2_hit,0)) AS m4_hit, " .
                    "SUM(if(bi2_usage.bi2_month=4,bi2_usage.bi2_value,0)) AS m4_value, " .
                    "SUM(if(bi2_usage.bi2_month=5,bi2_usage.bi2_qty,0)) AS m5_qty, " .
                    "SUM(if(bi2_usage.bi2_month=5,bi2_usage.bi2_hit,0)) AS m5_hit, " .
                    "SUM(if(bi2_usage.bi2_month=5,bi2_usage.bi2_value,0)) AS m5_value, " .
                    "SUM(if(bi2_usage.bi2_month=6,bi2_usage.bi2_qty,0)) AS m6_qty, " .
                    "SUM(if(bi2_usage.bi2_month=6,bi2_usage.bi2_hit,0)) AS m6_hit, " .
                    "SUM(if(bi2_usage.bi2_month=6,bi2_usage.bi2_value,0)) AS m6_value, " .
                    "SUM(if(bi2_usage.bi2_month=7,bi2_usage.bi2_qty,0)) AS m7_qty, " .
                    "SUM(if(bi2_usage.bi2_month=7,bi2_usage.bi2_hit,0)) AS m7_hit, " .
                    "SUM(if(bi2_usage.bi2_month=7,bi2_usage.bi2_value,0)) AS m7_value, " .
                    "SUM(if(bi2_usage.bi2_month=8,bi2_usage.bi2_qty,0)) AS m8_qty, " .
                    "SUM(if(bi2_usage.bi2_month=8,bi2_usage.bi2_hit,0)) AS m8_hit, " .
                    "SUM(if(bi2_usage.bi2_month=8,bi2_usage.bi2_value,0)) AS m8_value, " .
                    "SUM(if(bi2_usage.bi2_month=9,bi2_usage.bi2_qty,0)) AS m9_qty, " .
                    "SUM(if(bi2_usage.bi2_month=9,bi2_usage.bi2_hit,0)) AS m9_hit, " .
                    "SUM(if(bi2_usage.bi2_month=9,bi2_usage.bi2_value,0)) AS m9_value, " .
                    "SUM(if(bi2_usage.bi2_month=10,bi2_usage.bi2_qty,0)) AS m10_qty, " .
                    "SUM(if(bi2_usage.bi2_month=10,bi2_usage.bi2_hit,0)) AS m10_hit, " .
                    "SUM(if(bi2_usage.bi2_month=10,bi2_usage.bi2_value,0)) AS m10_value, " .
                    "SUM(if(bi2_usage.bi2_month=11,bi2_usage.bi2_qty,0)) AS m11_qty, " .
                    "SUM(if(bi2_usage.bi2_month=11,bi2_usage.bi2_hit,0)) AS m11_hit, " .
                    "SUM(if(bi2_usage.bi2_month=11,bi2_usage.bi2_value,0)) AS m11_value, " .
                    "SUM(if(bi2_usage.bi2_month=12,bi2_usage.bi2_qty,0)) AS m12_qty, " .
                    "SUM(if(bi2_usage.bi2_month=12,bi2_usage.bi2_hit,0)) AS m12_hit, " .
                    "SUM(if(bi2_usage.bi2_month=12,bi2_usage.bi2_value,0)) AS m12_value " .
                    "FROM bi2_usage " .
                    "LEFT JOIN bi1_bin ON (bi1_bin.id=bi2_usage.bi1_id) " .
                    "LEFT JOIN it1_item ON (it1_item.id=bi1_bin.it1_id) " .
                    "LEFT JOIN lo1_location ON (lo1_location.id=it1_item.lo1_id) " .
                    "LEFT JOIN fa1_facility ON (fa1_facility.id=lo1_location.fa1_id) " .
                    "WHERE " .
                    "(bi2_usage.bi2_year=:selectedYear) AND " .
                    "(it1_item.lo1_id=:selectedLocation) AND " .
                    "(lo1_location.fa1_id=:selectedFacility) AND " .
                    "(fa1_facility.cu1_id IN (" . implode(',', $this->selectedCustomers) . ")) AND " .
                    "(bi2_usage.delete_flag=0) " .
                    "GROUP BY " .
                    "fa1_facility.cu1_id, lo1_location.fa1_id, it1_item.lo1_id, bi2_usage.bi2_year";
                $command = $connection->createCommand($sql);
                $command->bindParam(":selectedYear", $this->selectedYear, PDO::PARAM_INT);
                $command->bindParam(":selectedLocation", $this->selectedLocation, PDO::PARAM_INT);
                $command->bindParam(":selectedFacility", $this->selectedFacility, PDO::PARAM_INT);
                $dataReader = $command->query();
                $rows = $dataReader->readAll();
                if ($rows === null) {
                    $rows = array();
                }
                $connection->active = false;
                // Data
                if (count($rows) == 1) {
                    $locationSalesHistory = array(
                        'items' => (int) $rows[0]['items'],
                        'totalValue' => (double) $rows[0]['totalValue'],
                        'totalQty' => (int) $rows[0]['totalQty'],
                        'totalHit' => (int) $rows[0]['totalHit'],
                        'saleValue' => array(),
                        'salesQuantity' => array(),
                        'orderCount' => array(),
                        'averageValue' => array(),
                    );
                    for ($m = 1; $m <= 12; $m++) {
                        $locationSalesHistory['saleValue'][] = (double) $rows[0]["m{$m}_value"];
                        $locationSalesHistory['salesQuantity'][] = (int) $rows[0]["m{$m}_qty"];
                        $locationSalesHistory['orderCount'][] = (int) $rows[0]["m{$m}_hit"];
                        if ((int) $rows[0]["m{$m}_hit"] > 0) {
                            $locationSalesHistory['averageValue'][] = (double) $rows[0]["m{$m}_value"] / (int) $rows[0]["m{$m}_hit"];
                        } else {
                            $locationSalesHistory['averageValue'][] = 0;
                        }
                    }
                    // Cache
                    Yii::app()->cache->set(
                        'locationSalesHistory-' . $this->selectedYear . '-' . $this->selectedType . '-' . implode('-', $this->selectedCustomers) . '-' . $this->selectedFacility . '-' . $this->selectedLocation, $locationSalesHistory, Yii::app()->params['dashboardLocationSalesHistoryCacheDuration']);
                } else {
                    $locationSalesHistory = array(
                        'items' => 0,
                        'totalValue' => 0,
                        'totalQty' => 0,
                        'totalHit' => 0,
                        'saleValue' => array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
                        'salesQuantity' => array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
                        'orderCount' => array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
                        'averageValue' => array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
                    );
                }
            } catch (Exception $ex) {
                $ex->getMessage();
            }
        }
        return $locationSalesHistory;
    }

    ////////////////////////////////////////////////////////////////////////////
    // Item
    /**
     * Returns the item's sales history.
     * @return array
     */
    public function getItemSalesHistory()
    {
        $itemSalesHistory = Yii::app()->cache->get(
            'itemSalesHistory-' . $this->selectedYear . '-' . $this->selectedType . '-' . implode('-', $this->selectedCustomers) . '-' . $this->selectedFacility . '-' . $this->selectedLocation . '-' . $this->selectedItem);
        if ($itemSalesHistory === false) {
            try {
                $connection = Yii::app()->db;
                $connection->active = true;
                $sql =
                    "SELECT " .
                    "fa1_facility.cu1_id, " .
                    "lo1_location.fa1_id, " .
                    "it1_item.lo1_id, " .
                    "bi1_bin.it1_id, " .
                    "bi2_usage.bi2_year, " .
                    "COUNT(DISTINCT bi2_usage.bi1_id) AS bins, " .
                    "SUM(bi2_usage.bi2_qty) AS totalQty, " .
                    "SUM(bi2_usage.bi2_hit) AS totalHit, " .
                    "SUM(bi2_usage.bi2_value) AS totalValue, " .
                    "SUM(if(bi2_usage.bi2_month=1,bi2_usage.bi2_qty,0)) AS m1_qty, " .
                    "SUM(if(bi2_usage.bi2_month=1,bi2_usage.bi2_hit,0)) AS m1_hit, " .
                    "SUM(if(bi2_usage.bi2_month=1,bi2_usage.bi2_value,0)) AS m1_value, " .
                    "SUM(if(bi2_usage.bi2_month=2,bi2_usage.bi2_qty,0)) AS m2_qty, " .
                    "SUM(if(bi2_usage.bi2_month=2,bi2_usage.bi2_hit,0)) AS m2_hit, " .
                    "SUM(if(bi2_usage.bi2_month=2,bi2_usage.bi2_value,0)) AS m2_value, " .
                    "SUM(if(bi2_usage.bi2_month=3,bi2_usage.bi2_qty,0)) AS m3_qty, " .
                    "SUM(if(bi2_usage.bi2_month=3,bi2_usage.bi2_hit,0)) AS m3_hit, " .
                    "SUM(if(bi2_usage.bi2_month=3,bi2_usage.bi2_value,0)) AS m3_value, " .
                    "SUM(if(bi2_usage.bi2_month=4,bi2_usage.bi2_qty,0)) AS m4_qty, " .
                    "SUM(if(bi2_usage.bi2_month=4,bi2_usage.bi2_hit,0)) AS m4_hit, " .
                    "SUM(if(bi2_usage.bi2_month=4,bi2_usage.bi2_value,0)) AS m4_value, " .
                    "SUM(if(bi2_usage.bi2_month=5,bi2_usage.bi2_qty,0)) AS m5_qty, " .
                    "SUM(if(bi2_usage.bi2_month=5,bi2_usage.bi2_hit,0)) AS m5_hit, " .
                    "SUM(if(bi2_usage.bi2_month=5,bi2_usage.bi2_value,0)) AS m5_value, " .
                    "SUM(if(bi2_usage.bi2_month=6,bi2_usage.bi2_qty,0)) AS m6_qty, " .
                    "SUM(if(bi2_usage.bi2_month=6,bi2_usage.bi2_hit,0)) AS m6_hit, " .
                    "SUM(if(bi2_usage.bi2_month=6,bi2_usage.bi2_value,0)) AS m6_value, " .
                    "SUM(if(bi2_usage.bi2_month=7,bi2_usage.bi2_qty,0)) AS m7_qty, " .
                    "SUM(if(bi2_usage.bi2_month=7,bi2_usage.bi2_hit,0)) AS m7_hit, " .
                    "SUM(if(bi2_usage.bi2_month=7,bi2_usage.bi2_value,0)) AS m7_value, " .
                    "SUM(if(bi2_usage.bi2_month=8,bi2_usage.bi2_qty,0)) AS m8_qty, " .
                    "SUM(if(bi2_usage.bi2_month=8,bi2_usage.bi2_hit,0)) AS m8_hit, " .
                    "SUM(if(bi2_usage.bi2_month=8,bi2_usage.bi2_value,0)) AS m8_value, " .
                    "SUM(if(bi2_usage.bi2_month=9,bi2_usage.bi2_qty,0)) AS m9_qty, " .
                    "SUM(if(bi2_usage.bi2_month=9,bi2_usage.bi2_hit,0)) AS m9_hit, " .
                    "SUM(if(bi2_usage.bi2_month=9,bi2_usage.bi2_value,0)) AS m9_value, " .
                    "SUM(if(bi2_usage.bi2_month=10,bi2_usage.bi2_qty,0)) AS m10_qty, " .
                    "SUM(if(bi2_usage.bi2_month=10,bi2_usage.bi2_hit,0)) AS m10_hit, " .
                    "SUM(if(bi2_usage.bi2_month=10,bi2_usage.bi2_value,0)) AS m10_value, " .
                    "SUM(if(bi2_usage.bi2_month=11,bi2_usage.bi2_qty,0)) AS m11_qty, " .
                    "SUM(if(bi2_usage.bi2_month=11,bi2_usage.bi2_hit,0)) AS m11_hit, " .
                    "SUM(if(bi2_usage.bi2_month=11,bi2_usage.bi2_value,0)) AS m11_value, " .
                    "SUM(if(bi2_usage.bi2_month=12,bi2_usage.bi2_qty,0)) AS m12_qty, " .
                    "SUM(if(bi2_usage.bi2_month=12,bi2_usage.bi2_hit,0)) AS m12_hit, " .
                    "SUM(if(bi2_usage.bi2_month=12,bi2_usage.bi2_value,0)) AS m12_value " .
                    "FROM bi2_usage " .
                    "LEFT JOIN bi1_bin ON (bi1_bin.id=bi2_usage.bi1_id) " .
                    "LEFT JOIN it1_item ON (it1_item.id=bi1_bin.it1_id) " .
                    "LEFT JOIN lo1_location ON (lo1_location.id=it1_item.lo1_id) " .
                    "LEFT JOIN fa1_facility ON (fa1_facility.id=lo1_location.fa1_id) " .
                    "WHERE " .
                    "(bi2_usage.bi2_year=:selectedYear) AND " .
                    "(bi1_bin.it1_id=:selectedItem) AND " .
                    "(it1_item.lo1_id=:selectedLocation) AND " .
                    "(lo1_location.fa1_id=:selectedFacility) AND " .
                    "(fa1_facility.cu1_id IN (" . implode(',', $this->selectedCustomers) . ")) AND " .
                    "(bi2_usage.delete_flag=0) " .
                    "GROUP BY " .
                    "fa1_facility.cu1_id, lo1_location.fa1_id, it1_item.lo1_id, bi1_bin.it1_id, bi2_usage.bi2_year";
                $command = $connection->createCommand($sql);
                $command->bindParam(":selectedYear", $this->selectedYear, PDO::PARAM_INT);
                $command->bindParam(":selectedItem", $this->selectedItem, PDO::PARAM_INT);
                $command->bindParam(":selectedLocation", $this->selectedLocation, PDO::PARAM_INT);
                $command->bindParam(":selectedFacility", $this->selectedFacility, PDO::PARAM_INT);
                $dataReader = $command->query();
                $rows = $dataReader->readAll();
                if ($rows === null) {
                    $rows = array();
                }
                $connection->active = false;
                // Data
                if (count($rows) == 1) {
                    $itemSalesHistory = array(
                        'bins' => (int) $rows[0]['bins'],
                        'totalValue' => (double) $rows[0]['totalValue'],
                        'totalQty' => (int) $rows[0]['totalQty'],
                        'totalHit' => (int) $rows[0]['totalHit'],
                        'saleValue' => array(),
                        'salesQuantity' => array(),
                        'orderCount' => array(),
                        'averageValue' => array(),
                    );
                    for ($m = 1; $m <= 12; $m++) {
                        $itemSalesHistory['saleValue'][] = (double) $rows[0]["m{$m}_value"];
                        $itemSalesHistory['salesQuantity'][] = (int) $rows[0]["m{$m}_qty"];
                        $itemSalesHistory['orderCount'][] = (int) $rows[0]["m{$m}_hit"];
                        if ((int) $rows[0]["m{$m}_hit"] > 0) {
                            $itemSalesHistory['averageValue'][] = (double) $rows[0]["m{$m}_value"] / (int) $rows[0]["m{$m}_hit"];
                        } else {
                            $itemSalesHistory['averageValue'][] = 0;
                        }
                    }
                    // Cache
                    Yii::app()->cache->set(
                        'itemSalesHistory-' . $this->selectedYear . '-' . $this->selectedType . '-' . implode('-', $this->selectedCustomers) . '-' . $this->selectedFacility . '-' . $this->selectedLocation . '-' . $this->selectedItem, $itemSalesHistory, Yii::app()->params['dashboardItemSalesHistoryCacheDuration']);
                } else {
                    $itemSalesHistory = array(
                        'bins' => 0,
                        'totalValue' => 0,
                        'totalQty' => 0,
                        'totalHit' => 0,
                        'saleValue' => array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
                        'salesQuantity' => array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
                        'orderCount' => array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
                        'averageValue' => array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
                    );
                }
            } catch (Exception $ex) {
                $ex->getMessage();
            }
        }
        return $itemSalesHistory;
    }

}
