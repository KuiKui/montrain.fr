<?php


/**
 * This class defines the structure of the 'discussion' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class DiscussionTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.DiscussionTableMap';

	/**
	 * Initialize the table attributes, columns and validators
	 * Relations are not initialized by this method since they are lazy loaded
	 *
	 * @return     void
	 * @throws     PropelException
	 */
	public function initialize()
	{
	  // attributes
		$this->setName('discussion');
		$this->setPhpName('Discussion');
		$this->setClassname('Discussion');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
		$this->addForeignKey('LIGNE_ID', 'LigneId', 'INTEGER', 'ligne', 'ID', true, null, null);
		$this->addColumn('NOM', 'Nom', 'VARCHAR', true, 255, null);
		$this->addColumn('NOMBRE_MESSAGE', 'NombreMessage', 'INTEGER', true, null, 0);
		$this->addColumn('IMPORTANTE', 'Importante', 'BOOLEAN', true, null, false);
		$this->addColumn('VALIDE', 'Valide', 'BOOLEAN', true, null, true);
		$this->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null, null);
		$this->addColumn('UPDATED_AT', 'UpdatedAt', 'TIMESTAMP', false, null, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('Ligne', 'Ligne', RelationMap::MANY_TO_ONE, array('ligne_id' => 'id', ), null, null);
    $this->addRelation('Message', 'Message', RelationMap::ONE_TO_MANY, array('id' => 'discussion_id', ), null, null);
	} // buildRelations()

	/**
	 * 
	 * Gets the list of behaviors registered for this table
	 * 
	 * @return array Associative array (name => parameters) of behaviors
	 */
	public function getBehaviors()
	{
		return array(
			'symfony' => array('form' => 'true', 'filter' => 'true', ),
			'symfony_behaviors' => array(),
			'symfony_timestampable' => array('create_column' => 'created_at', 'update_column' => 'updated_at', ),
		);
	} // getBehaviors()

} // DiscussionTableMap
