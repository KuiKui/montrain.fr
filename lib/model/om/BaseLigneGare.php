<?php

/**
 * Base class that represents a row from the 'ligne_gare' table.
 *
 * 
 *
 * @package    lib.model.om
 */
abstract class BaseLigneGare extends BaseObject  implements Persistent {


	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        LigneGarePeer
	 */
	protected static $peer;

	/**
	 * The value for the ligne_id field.
	 * @var        int
	 */
	protected $ligne_id;

	/**
	 * The value for the gare_id field.
	 * @var        int
	 */
	protected $gare_id;

	/**
	 * The value for the valide field.
	 * Note: this column has a database default value of: true
	 * @var        boolean
	 */
	protected $valide;

	/**
	 * @var        Ligne
	 */
	protected $aLigne;

	/**
	 * @var        Gare
	 */
	protected $aGare;

	/**
	 * Flag to prevent endless save loop, if this object is referenced
	 * by another object which falls in this transaction.
	 * @var        boolean
	 */
	protected $alreadyInSave = false;

	/**
	 * Flag to prevent endless validation loop, if this object is referenced
	 * by another object which falls in this transaction.
	 * @var        boolean
	 */
	protected $alreadyInValidation = false;

	// symfony behavior
	
	const PEER = 'LigneGarePeer';

	/**
	 * Applies default values to this object.
	 * This method should be called from the object's constructor (or
	 * equivalent initialization method).
	 * @see        __construct()
	 */
	public function applyDefaultValues()
	{
		$this->valide = true;
	}

	/**
	 * Initializes internal state of BaseLigneGare object.
	 * @see        applyDefaults()
	 */
	public function __construct()
	{
		parent::__construct();
		$this->applyDefaultValues();
	}

	/**
	 * Get the [ligne_id] column value.
	 * 
	 * @return     int
	 */
	public function getLigneId()
	{
		return $this->ligne_id;
	}

	/**
	 * Get the [gare_id] column value.
	 * 
	 * @return     int
	 */
	public function getGareId()
	{
		return $this->gare_id;
	}

	/**
	 * Get the [valide] column value.
	 * 
	 * @return     boolean
	 */
	public function getValide()
	{
		return $this->valide;
	}

	/**
	 * Set the value of [ligne_id] column.
	 * 
	 * @param      int $v new value
	 * @return     LigneGare The current object (for fluent API support)
	 */
	public function setLigneId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->ligne_id !== $v) {
			$this->ligne_id = $v;
			$this->modifiedColumns[] = LigneGarePeer::LIGNE_ID;
		}

		if ($this->aLigne !== null && $this->aLigne->getId() !== $v) {
			$this->aLigne = null;
		}

		return $this;
	} // setLigneId()

	/**
	 * Set the value of [gare_id] column.
	 * 
	 * @param      int $v new value
	 * @return     LigneGare The current object (for fluent API support)
	 */
	public function setGareId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->gare_id !== $v) {
			$this->gare_id = $v;
			$this->modifiedColumns[] = LigneGarePeer::GARE_ID;
		}

		if ($this->aGare !== null && $this->aGare->getId() !== $v) {
			$this->aGare = null;
		}

		return $this;
	} // setGareId()

	/**
	 * Set the value of [valide] column.
	 * 
	 * @param      boolean $v new value
	 * @return     LigneGare The current object (for fluent API support)
	 */
	public function setValide($v)
	{
		if ($v !== null) {
			$v = (boolean) $v;
		}

		if ($this->valide !== $v || $this->isNew()) {
			$this->valide = $v;
			$this->modifiedColumns[] = LigneGarePeer::VALIDE;
		}

		return $this;
	} // setValide()

	/**
	 * Indicates whether the columns in this object are only set to default values.
	 *
	 * This method can be used in conjunction with isModified() to indicate whether an object is both
	 * modified _and_ has some values set which are non-default.
	 *
	 * @return     boolean Whether the columns in this object are only been set with default values.
	 */
	public function hasOnlyDefaultValues()
	{
			if ($this->valide !== true) {
				return false;
			}

		// otherwise, everything was equal, so return TRUE
		return true;
	} // hasOnlyDefaultValues()

	/**
	 * Hydrates (populates) the object variables with values from the database resultset.
	 *
	 * An offset (0-based "start column") is specified so that objects can be hydrated
	 * with a subset of the columns in the resultset rows.  This is needed, for example,
	 * for results of JOIN queries where the resultset row includes columns from two or
	 * more tables.
	 *
	 * @param      array $row The row returned by PDOStatement->fetch(PDO::FETCH_NUM)
	 * @param      int $startcol 0-based offset column which indicates which restultset column to start with.
	 * @param      boolean $rehydrate Whether this object is being re-hydrated from the database.
	 * @return     int next starting column
	 * @throws     PropelException  - Any caught Exception will be rewrapped as a PropelException.
	 */
	public function hydrate($row, $startcol = 0, $rehydrate = false)
	{
		try {

			$this->ligne_id = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
			$this->gare_id = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
			$this->valide = ($row[$startcol + 2] !== null) ? (boolean) $row[$startcol + 2] : null;
			$this->resetModified();

			$this->setNew(false);

			if ($rehydrate) {
				$this->ensureConsistency();
			}

			// FIXME - using NUM_COLUMNS may be clearer.
			return $startcol + 3; // 3 = LigneGarePeer::NUM_COLUMNS - LigneGarePeer::NUM_LAZY_LOAD_COLUMNS).

		} catch (Exception $e) {
			throw new PropelException("Error populating LigneGare object", $e);
		}
	}

	/**
	 * Checks and repairs the internal consistency of the object.
	 *
	 * This method is executed after an already-instantiated object is re-hydrated
	 * from the database.  It exists to check any foreign keys to make sure that
	 * the objects related to the current object are correct based on foreign key.
	 *
	 * You can override this method in the stub class, but you should always invoke
	 * the base method from the overridden method (i.e. parent::ensureConsistency()),
	 * in case your model changes.
	 *
	 * @throws     PropelException
	 */
	public function ensureConsistency()
	{

		if ($this->aLigne !== null && $this->ligne_id !== $this->aLigne->getId()) {
			$this->aLigne = null;
		}
		if ($this->aGare !== null && $this->gare_id !== $this->aGare->getId()) {
			$this->aGare = null;
		}
	} // ensureConsistency

	/**
	 * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
	 *
	 * This will only work if the object has been saved and has a valid primary key set.
	 *
	 * @param      boolean $deep (optional) Whether to also de-associated any related objects.
	 * @param      PropelPDO $con (optional) The PropelPDO connection to use.
	 * @return     void
	 * @throws     PropelException - if this object is deleted, unsaved or doesn't have pk match in db
	 */
	public function reload($deep = false, PropelPDO $con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("Cannot reload a deleted object.");
		}

		if ($this->isNew()) {
			throw new PropelException("Cannot reload an unsaved object.");
		}

		if ($con === null) {
			$con = Propel::getConnection(LigneGarePeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		// We don't need to alter the object instance pool; we're just modifying this instance
		// already in the pool.

		$stmt = LigneGarePeer::doSelectStmt($this->buildPkeyCriteria(), $con);
		$row = $stmt->fetch(PDO::FETCH_NUM);
		$stmt->closeCursor();
		if (!$row) {
			throw new PropelException('Cannot find matching row in the database to reload object values.');
		}
		$this->hydrate($row, 0, true); // rehydrate

		if ($deep) {  // also de-associate any related objects?

			$this->aLigne = null;
			$this->aGare = null;
		} // if (deep)
	}

	/**
	 * Removes this object from datastore and sets delete attribute.
	 *
	 * @param      PropelPDO $con
	 * @return     void
	 * @throws     PropelException
	 * @see        BaseObject::setDeleted()
	 * @see        BaseObject::isDeleted()
	 */
	public function delete(PropelPDO $con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(LigneGarePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			$ret = $this->preDelete($con);
			// symfony_behaviors behavior
			foreach (sfMixer::getCallables('BaseLigneGare:delete:pre') as $callable)
			{
			  if (call_user_func($callable, $this, $con))
			  {
			    $con->commit();
			
			    return;
			  }
			}

			if ($ret) {
				LigneGarePeer::doDelete($this, $con);
				$this->postDelete($con);
				// symfony_behaviors behavior
				foreach (sfMixer::getCallables('BaseLigneGare:delete:post') as $callable)
				{
				  call_user_func($callable, $this, $con);
				}

				$this->setDeleted(true);
				$con->commit();
			} else {
				$con->commit();
			}
		} catch (PropelException $e) {
			$con->rollBack();
			throw $e;
		}
	}

	/**
	 * Persists this object to the database.
	 *
	 * If the object is new, it inserts it; otherwise an update is performed.
	 * All modified related objects will also be persisted in the doSave()
	 * method.  This method wraps all precipitate database operations in a
	 * single transaction.
	 *
	 * @param      PropelPDO $con
	 * @return     int The number of rows affected by this insert/update and any referring fk objects' save() operations.
	 * @throws     PropelException
	 * @see        doSave()
	 */
	public function save(PropelPDO $con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(LigneGarePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		$isInsert = $this->isNew();
		try {
			$ret = $this->preSave($con);
			// symfony_behaviors behavior
			foreach (sfMixer::getCallables('BaseLigneGare:save:pre') as $callable)
			{
			  if (is_integer($affectedRows = call_user_func($callable, $this, $con)))
			  {
			    $con->commit();
			
			    return $affectedRows;
			  }
			}

			if ($isInsert) {
				$ret = $ret && $this->preInsert($con);
			} else {
				$ret = $ret && $this->preUpdate($con);
			}
			if ($ret) {
				$affectedRows = $this->doSave($con);
				if ($isInsert) {
					$this->postInsert($con);
				} else {
					$this->postUpdate($con);
				}
				$this->postSave($con);
				// symfony_behaviors behavior
				foreach (sfMixer::getCallables('BaseLigneGare:save:post') as $callable)
				{
				  call_user_func($callable, $this, $con, $affectedRows);
				}

				LigneGarePeer::addInstanceToPool($this);
			} else {
				$affectedRows = 0;
			}
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollBack();
			throw $e;
		}
	}

	/**
	 * Performs the work of inserting or updating the row in the database.
	 *
	 * If the object is new, it inserts it; otherwise an update is performed.
	 * All related objects are also updated in this method.
	 *
	 * @param      PropelPDO $con
	 * @return     int The number of rows affected by this insert/update and any referring fk objects' save() operations.
	 * @throws     PropelException
	 * @see        save()
	 */
	protected function doSave(PropelPDO $con)
	{
		$affectedRows = 0; // initialize var to track total num of affected rows
		if (!$this->alreadyInSave) {
			$this->alreadyInSave = true;

			// We call the save method on the following object(s) if they
			// were passed to this object by their coresponding set
			// method.  This object relates to these object(s) by a
			// foreign key reference.

			if ($this->aLigne !== null) {
				if ($this->aLigne->isModified() || $this->aLigne->isNew()) {
					$affectedRows += $this->aLigne->save($con);
				}
				$this->setLigne($this->aLigne);
			}

			if ($this->aGare !== null) {
				if ($this->aGare->isModified() || $this->aGare->isNew()) {
					$affectedRows += $this->aGare->save($con);
				}
				$this->setGare($this->aGare);
			}


			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = LigneGarePeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setNew(false);
				} else {
					$affectedRows += LigneGarePeer::doUpdate($this, $con);
				}

				$this->resetModified(); // [HL] After being saved an object is no longer 'modified'
			}

			$this->alreadyInSave = false;

		}
		return $affectedRows;
	} // doSave()

	/**
	 * Array of ValidationFailed objects.
	 * @var        array ValidationFailed[]
	 */
	protected $validationFailures = array();

	/**
	 * Gets any ValidationFailed objects that resulted from last call to validate().
	 *
	 *
	 * @return     array ValidationFailed[]
	 * @see        validate()
	 */
	public function getValidationFailures()
	{
		return $this->validationFailures;
	}

	/**
	 * Validates the objects modified field values and all objects related to this table.
	 *
	 * If $columns is either a column name or an array of column names
	 * only those columns are validated.
	 *
	 * @param      mixed $columns Column name or an array of column names.
	 * @return     boolean Whether all columns pass validation.
	 * @see        doValidate()
	 * @see        getValidationFailures()
	 */
	public function validate($columns = null)
	{
		$res = $this->doValidate($columns);
		if ($res === true) {
			$this->validationFailures = array();
			return true;
		} else {
			$this->validationFailures = $res;
			return false;
		}
	}

	/**
	 * This function performs the validation work for complex object models.
	 *
	 * In addition to checking the current object, all related objects will
	 * also be validated.  If all pass then <code>true</code> is returned; otherwise
	 * an aggreagated array of ValidationFailed objects will be returned.
	 *
	 * @param      array $columns Array of column names to validate.
	 * @return     mixed <code>true</code> if all validations pass; array of <code>ValidationFailed</code> objets otherwise.
	 */
	protected function doValidate($columns = null)
	{
		if (!$this->alreadyInValidation) {
			$this->alreadyInValidation = true;
			$retval = null;

			$failureMap = array();


			// We call the validate method on the following object(s) if they
			// were passed to this object by their coresponding set
			// method.  This object relates to these object(s) by a
			// foreign key reference.

			if ($this->aLigne !== null) {
				if (!$this->aLigne->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aLigne->getValidationFailures());
				}
			}

			if ($this->aGare !== null) {
				if (!$this->aGare->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aGare->getValidationFailures());
				}
			}


			if (($retval = LigneGarePeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	/**
	 * Retrieves a field from the object by name passed in as a string.
	 *
	 * @param      string $name name
	 * @param      string $type The type of fieldname the $name is of:
	 *                     one of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
	 *                     BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM
	 * @return     mixed Value of field.
	 */
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = LigneGarePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		$field = $this->getByPosition($pos);
		return $field;
	}

	/**
	 * Retrieves a field from the object by Position as specified in the xml schema.
	 * Zero-based.
	 *
	 * @param      int $pos position in xml schema
	 * @return     mixed Value of field at $pos
	 */
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getLigneId();
				break;
			case 1:
				return $this->getGareId();
				break;
			case 2:
				return $this->getValide();
				break;
			default:
				return null;
				break;
		} // switch()
	}

	/**
	 * Exports the object as an array.
	 *
	 * You can specify the key type of the array by passing one of the class
	 * type constants.
	 *
	 * @param      string $keyType (optional) One of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
	 *                        BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM. Defaults to BasePeer::TYPE_PHPNAME.
	 * @param      boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns.  Defaults to TRUE.
	 * @return     an associative array containing the field names (as keys) and field values
	 */
	public function toArray($keyType = BasePeer::TYPE_PHPNAME, $includeLazyLoadColumns = true)
	{
		$keys = LigneGarePeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getLigneId(),
			$keys[1] => $this->getGareId(),
			$keys[2] => $this->getValide(),
		);
		return $result;
	}

	/**
	 * Sets a field from the object by name passed in as a string.
	 *
	 * @param      string $name peer name
	 * @param      mixed $value field value
	 * @param      string $type The type of fieldname the $name is of:
	 *                     one of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
	 *                     BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM
	 * @return     void
	 */
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = LigneGarePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	/**
	 * Sets a field from the object by Position as specified in the xml schema.
	 * Zero-based.
	 *
	 * @param      int $pos position in xml schema
	 * @param      mixed $value field value
	 * @return     void
	 */
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setLigneId($value);
				break;
			case 1:
				$this->setGareId($value);
				break;
			case 2:
				$this->setValide($value);
				break;
		} // switch()
	}

	/**
	 * Populates the object using an array.
	 *
	 * This is particularly useful when populating an object from one of the
	 * request arrays (e.g. $_POST).  This method goes through the column
	 * names, checking to see whether a matching key exists in populated
	 * array. If so the setByName() method is called for that column.
	 *
	 * You can specify the key type of the array by additionally passing one
	 * of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME,
	 * BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
	 * The default key type is the column's phpname (e.g. 'AuthorId')
	 *
	 * @param      array  $arr     An array to populate the object from.
	 * @param      string $keyType The type of keys the array uses.
	 * @return     void
	 */
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = LigneGarePeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setLigneId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setGareId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setValide($arr[$keys[2]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(LigneGarePeer::DATABASE_NAME);

		if ($this->isColumnModified(LigneGarePeer::LIGNE_ID)) $criteria->add(LigneGarePeer::LIGNE_ID, $this->ligne_id);
		if ($this->isColumnModified(LigneGarePeer::GARE_ID)) $criteria->add(LigneGarePeer::GARE_ID, $this->gare_id);
		if ($this->isColumnModified(LigneGarePeer::VALIDE)) $criteria->add(LigneGarePeer::VALIDE, $this->valide);

		return $criteria;
	}

	/**
	 * Builds a Criteria object containing the primary key for this object.
	 *
	 * Unlike buildCriteria() this method includes the primary key values regardless
	 * of whether or not they have been modified.
	 *
	 * @return     Criteria The Criteria object containing value(s) for primary key(s).
	 */
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(LigneGarePeer::DATABASE_NAME);

		$criteria->add(LigneGarePeer::LIGNE_ID, $this->ligne_id);
		$criteria->add(LigneGarePeer::GARE_ID, $this->gare_id);

		return $criteria;
	}

	/**
	 * Returns the composite primary key for this object.
	 * The array elements will be in same order as specified in XML.
	 * @return     array
	 */
	public function getPrimaryKey()
	{
		$pks = array();

		$pks[0] = $this->getLigneId();

		$pks[1] = $this->getGareId();

		return $pks;
	}

	/**
	 * Set the [composite] primary key.
	 *
	 * @param      array $keys The elements of the composite key (order must match the order in XML file).
	 * @return     void
	 */
	public function setPrimaryKey($keys)
	{

		$this->setLigneId($keys[0]);

		$this->setGareId($keys[1]);

	}

	/**
	 * Sets contents of passed object to values from current object.
	 *
	 * If desired, this method can also make copies of all associated (fkey referrers)
	 * objects.
	 *
	 * @param      object $copyObj An object of LigneGare (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setLigneId($this->ligne_id);

		$copyObj->setGareId($this->gare_id);

		$copyObj->setValide($this->valide);


		$copyObj->setNew(true);

	}

	/**
	 * Makes a copy of this object that will be inserted as a new row in table when saved.
	 * It creates a new object filling in the simple attributes, but skipping any primary
	 * keys that are defined for the table.
	 *
	 * If desired, this method can also make copies of all associated (fkey referrers)
	 * objects.
	 *
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @return     LigneGare Clone of current object.
	 * @throws     PropelException
	 */
	public function copy($deepCopy = false)
	{
		// we use get_class(), because this might be a subclass
		$clazz = get_class($this);
		$copyObj = new $clazz();
		$this->copyInto($copyObj, $deepCopy);
		return $copyObj;
	}

	/**
	 * Returns a peer instance associated with this om.
	 *
	 * Since Peer classes are not to have any instance attributes, this method returns the
	 * same instance for all member of this class. The method could therefore
	 * be static, but this would prevent one from overriding the behavior.
	 *
	 * @return     LigneGarePeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new LigneGarePeer();
		}
		return self::$peer;
	}

	/**
	 * Declares an association between this object and a Ligne object.
	 *
	 * @param      Ligne $v
	 * @return     LigneGare The current object (for fluent API support)
	 * @throws     PropelException
	 */
	public function setLigne(Ligne $v = null)
	{
		if ($v === null) {
			$this->setLigneId(NULL);
		} else {
			$this->setLigneId($v->getId());
		}

		$this->aLigne = $v;

		// Add binding for other direction of this n:n relationship.
		// If this object has already been added to the Ligne object, it will not be re-added.
		if ($v !== null) {
			$v->addLigneGare($this);
		}

		return $this;
	}


	/**
	 * Get the associated Ligne object
	 *
	 * @param      PropelPDO Optional Connection object.
	 * @return     Ligne The associated Ligne object.
	 * @throws     PropelException
	 */
	public function getLigne(PropelPDO $con = null)
	{
		if ($this->aLigne === null && ($this->ligne_id !== null)) {
			$this->aLigne = LignePeer::retrieveByPk($this->ligne_id);
			/* The following can be used additionally to
			   guarantee the related object contains a reference
			   to this object.  This level of coupling may, however, be
			   undesirable since it could result in an only partially populated collection
			   in the referenced object.
			   $this->aLigne->addLigneGares($this);
			 */
		}
		return $this->aLigne;
	}

	/**
	 * Declares an association between this object and a Gare object.
	 *
	 * @param      Gare $v
	 * @return     LigneGare The current object (for fluent API support)
	 * @throws     PropelException
	 */
	public function setGare(Gare $v = null)
	{
		if ($v === null) {
			$this->setGareId(NULL);
		} else {
			$this->setGareId($v->getId());
		}

		$this->aGare = $v;

		// Add binding for other direction of this n:n relationship.
		// If this object has already been added to the Gare object, it will not be re-added.
		if ($v !== null) {
			$v->addLigneGare($this);
		}

		return $this;
	}


	/**
	 * Get the associated Gare object
	 *
	 * @param      PropelPDO Optional Connection object.
	 * @return     Gare The associated Gare object.
	 * @throws     PropelException
	 */
	public function getGare(PropelPDO $con = null)
	{
		if ($this->aGare === null && ($this->gare_id !== null)) {
			$this->aGare = GarePeer::retrieveByPk($this->gare_id);
			/* The following can be used additionally to
			   guarantee the related object contains a reference
			   to this object.  This level of coupling may, however, be
			   undesirable since it could result in an only partially populated collection
			   in the referenced object.
			   $this->aGare->addLigneGares($this);
			 */
		}
		return $this->aGare;
	}

	/**
	 * Resets all collections of referencing foreign keys.
	 *
	 * This method is a user-space workaround for PHP's inability to garbage collect objects
	 * with circular references.  This is currently necessary when using Propel in certain
	 * daemon or large-volumne/high-memory operations.
	 *
	 * @param      boolean $deep Whether to also clear the references on all associated objects.
	 */
	public function clearAllReferences($deep = false)
	{
		if ($deep) {
		} // if ($deep)

			$this->aLigne = null;
			$this->aGare = null;
	}

	// symfony_behaviors behavior
	
	/**
	 * Calls methods defined via {@link sfMixer}.
	 */
	public function __call($method, $arguments)
	{
	  if (!$callable = sfMixer::getCallable('BaseLigneGare:'.$method))
	  {
	    throw new sfException(sprintf('Call to undefined method BaseLigneGare::%s', $method));
	  }
	
	  array_unshift($arguments, $this);
	
	  return call_user_func_array($callable, $arguments);
	}

} // BaseLigneGare
