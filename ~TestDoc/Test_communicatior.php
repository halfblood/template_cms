<?php
require_once 'components/com_communications/communications.php';
require_once 'PHPUnit\Framework\TestCase.php';

/**
 * test case.
 */
class Test_communicatior extends PHPUnit_Framework_TestCase {
	
	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp() {
		parent::setUp ();
	
		// TODO Auto-generated Test_communicatior::setUp()
	

	}
	
	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown() {
		// TODO Auto-generated Test_communicatior::tearDown()
		

		parent::tearDown ();
	}
	
	/**
	 * Constructs the test case.
	 */
	public function __construct() {
		// TODO Auto-generated constructor
	}
	
	//测试添加记录功能
	public function addRecordAndGetPublishedRowsTest()
	{
		$db = & JFactory::getDBO();
	    $query = "INSERT INTO #_communications VALUES('',111','11','','','','',1 )";
        $db->setQuery( $query );
		$this->assertNull(getPublishedRows());
	}
	//测试删除记录功能
	public function deleteRecordAndGetPublishedRowsTest()
	{
		$db = & JFactory::getDBO();
	    $query = "SELECT * FROM #__communications WHERE
             published = '1' ORDER BY review_date DESC";
        $db->setQuery( $query );
	    $rows = $db->loadObjectList();
        foreach($rows as $row)
        {
            $row->published = 0;
        }
        $this->assertNotNull(getPublishedRows());
	}
	//测试返回值是否为空
	public function isGetRowByIdReturnNullTest()
	{
		$this->assertNull(getRowById());
	}
	//测试返回值是否正确
	public function isGetRowByIdCorrectTest()
	{
		$row =& JTable::getInstance('communication', 'Table');
		$id = 2;
        $row->load($id);
        $this->assertEquals($row, getRowById($id));
	}
	
	public function isGetCommunicationsCommentsByIdReturnNullTest()
	{
		$this->assertNull(getCommunicationsCommentsById());
	}
	
	public function isGetCommunicationsCommentsByIdReturnCorrectTest()
	{
		$db =& JFactory::getDBO();
		$id = 2;
        $db->setQuery("SELECT * FROM #__communications_comments
                      WHERE review_id = '$id'");
        $rows = $db->loadObjectList();	
        $this->assertEquals($rows, getCommunicationsCommentsById($id));
	}
	//测试页面跳转是否正确
	public function isAddCommentDirectToRightPageTest()
	{
		addComment('add');
		$this->assertEquals('index.php?option=com_communications&task=add', $mainframe->currentPage);
	}
	//测试用户ID是否可用
	public function isUserIdValidTest()
	{
		$user =& JFactory::getUser();
		$db = getPublishedRows();
		$row = $db->loadObject();
		$this->assertEquals($row->id, $user->id);
	}
}

class TimeTest_communicator extends PHPUnit_Extensions_PerformanceTestCase {
	
	public function Timetest_showPublishedCommunications(){
		$this->setMaxRunningTime(0.001);
		$test_option;
		$row=showPublishedCommunications($test_option);
	}
	//测试获取行操作是否超时
	public function Timetest_getPublishedRows(){
		$this->setMaxRunningTime(0.001);
		$row=getPublishedRows();
	}
	
}

