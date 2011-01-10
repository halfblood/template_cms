<?php
require_once 'administrator/components/com_communications/admin.communications.php';
require_once 'PHPUnit\Framework\TestCase.php';

/**
 * test case.
 */
class Test_admincommunications extends PHPUnit_Framework_TestCase {
	
	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp() {
		parent::setUp ();
	
		// TODO Auto-generated Test::setUp()
	}
	
	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown() {
		// TODO Auto-generated Test::tearDown()
		parent::tearDown ();
	}
	
	/**
	 * Constructs the test case.
	 */
	public function __construct() {
		// TODO Auto-generated constructor
	}
    
	//分别对三种初始化操作做超时测试
	public function test_initialRow()
	{
		$this->assertNull(initialRow());
	}
	
	public function test_initialLists()
	{
		$this->assertNull(initialLists());
	}
	
	public function test_initialReservations()
	{
		$this->assertNull(initialReservations());
	}
	//测试行是否合法
	public function test_isRowValid()
	{
		$row=initialRow();
		if (!$row->review_date)
			$this->assertType(date( 'Y-m-d H:i:s' ), $row->review_date);
	}
	//测试存储功能
	public function test_IfCanBeStore()
	{
		$row=initialRow();
		$this->assertTrue(!$row->store());
	}
	
	public function test_getQuicktake()
	{
		$row=initialRow();
		$quicktake=JRequest::getVar( 'quicktake', '', 'post',
         'string', JREQUEST_ALLOWRAW );
		$this->assertEquals($quicktake, $row->quicktake);
	}
	//测试获取操作
	public function test_getReview()
	{
		$row=initialRow();
		$review=JRequest::getVar( 'review', '', 'post',
      	'string', JREQUEST_ALLOWRAW );
		$this->assertEquals($review, $row->review);
	}
	
	//当操作为apply时，测试编辑操作和页面跳转是否正确
	public function  test_LinkIfApply()
	{
		$row=initialRow();
		$task=apply;
		$msg;
		$linkl;
		$m='Changes to Communication saved';
		$l='index.php?option=com_communications
                &task=edit&cid[]='. $row->id;
		editMessageAndLink($row,$task,&$msg,&$link);
		$this->assertEquals($m,$msg);
	}
	//当操作为Save时，测试编辑操作和页面跳转是否正确
	public function  test_LinkIfSave()
	{
		$row=initialRow();
		$task=save;
		$msg;
		$linkl;
		$m='Changes to Communication saved';
		$l='index.php?option=com_communications
                &task=edit&cid[]='. $row->id;
		editMessageAndLink($row,$task,&$msg,&$link);
		$this->assertEquals($m,$msg);
	}
	
	public function test_getAllCommunicationsToDb()
	{
		$this->assertNull(getAllCommunicationsToDb());
	}
}

//超时测试
class TimeTest_admincommunications extends PHPUnit_Extensions_PerformanceTestCase {
	public function Timetest_initialRow(){
		$this->setMaxRunningTime(0.001);
		$row=initialRow();
	}
	public function Timetest_initialList(){
		$this->setMaxRunningTime(0.001);
		$row=initialList();
	}
	public function Timetest_saveCommunication(){
		$this->setMaxRunningTime(0.002);
		$row=saveCommunication();
	}
	public function Timetest_showCommunication(){
		$this->setMaxRunningTime(0.002);
		$row=showCommunication();
	}
}
