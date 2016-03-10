<?php

namespace Base;

use \Team as ChildTeam;
use \TeamMember as ChildTeamMember;
use \TeamMemberQuery as ChildTeamMemberQuery;
use \TeamQuery as ChildTeamQuery;
use \TeamTeamMember as ChildTeamTeamMember;
use \TeamTeamMemberQuery as ChildTeamTeamMemberQuery;
use \Exception;
use \PDO;
use Map\TeamTableMap;
use Map\TeamTeamMemberTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;

/**
 * Base class that represents a row from the 'TEAM' table.
 *
 *
 *
* @package    propel.generator..Base
*/
abstract class Team implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\TeamTableMap';


    /**
     * attribute to determine if this object has previously been saved.
     * @var boolean
     */
    protected $new = true;

    /**
     * attribute to determine whether this object has been deleted.
     * @var boolean
     */
    protected $deleted = false;

    /**
     * The columns that have been modified in current object.
     * Tracking modified columns allows us to only update modified columns.
     * @var array
     */
    protected $modifiedColumns = array();

    /**
     * The (virtual) columns that are added at runtime
     * The formatters can add supplementary columns based on a resultset
     * @var array
     */
    protected $virtualColumns = array();

    /**
     * The value for the id field.
     *
     * @var        int
     */
    protected $id;

    /**
     * The value for the name field.
     *
     * @var        string
     */
    protected $name;

    /**
     * @var        ObjectCollection|ChildTeamTeamMember[] Collection to store aggregation of ChildTeamTeamMember objects.
     */
    protected $collTeamTeamMembers;
    protected $collTeamTeamMembersPartial;

    /**
     * @var        ObjectCollection|ChildTeamMember[] Cross Collection to store aggregation of ChildTeamMember objects.
     */
    protected $collTeamMembers;

    /**
     * @var bool
     */
    protected $collTeamMembersPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildTeamMember[]
     */
    protected $teamMembersScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildTeamTeamMember[]
     */
    protected $teamTeamMembersScheduledForDeletion = null;

    /**
     * Initializes internal state of Base\Team object.
     */
    public function __construct()
    {
    }

    /**
     * Returns whether the object has been modified.
     *
     * @return boolean True if the object has been modified.
     */
    public function isModified()
    {
        return !!$this->modifiedColumns;
    }

    /**
     * Has specified column been modified?
     *
     * @param  string  $col column fully qualified name (TableMap::TYPE_COLNAME), e.g. Book::AUTHOR_ID
     * @return boolean True if $col has been modified.
     */
    public function isColumnModified($col)
    {
        return $this->modifiedColumns && isset($this->modifiedColumns[$col]);
    }

    /**
     * Get the columns that have been modified in this object.
     * @return array A unique list of the modified column names for this object.
     */
    public function getModifiedColumns()
    {
        return $this->modifiedColumns ? array_keys($this->modifiedColumns) : [];
    }

    /**
     * Returns whether the object has ever been saved.  This will
     * be false, if the object was retrieved from storage or was created
     * and then saved.
     *
     * @return boolean true, if the object has never been persisted.
     */
    public function isNew()
    {
        return $this->new;
    }

    /**
     * Setter for the isNew attribute.  This method will be called
     * by Propel-generated children and objects.
     *
     * @param boolean $b the state of the object.
     */
    public function setNew($b)
    {
        $this->new = (boolean) $b;
    }

    /**
     * Whether this object has been deleted.
     * @return boolean The deleted state of this object.
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * Specify whether this object has been deleted.
     * @param  boolean $b The deleted state of this object.
     * @return void
     */
    public function setDeleted($b)
    {
        $this->deleted = (boolean) $b;
    }

    /**
     * Sets the modified state for the object to be false.
     * @param  string $col If supplied, only the specified column is reset.
     * @return void
     */
    public function resetModified($col = null)
    {
        if (null !== $col) {
            if (isset($this->modifiedColumns[$col])) {
                unset($this->modifiedColumns[$col]);
            }
        } else {
            $this->modifiedColumns = array();
        }
    }

    /**
     * Compares this with another <code>Team</code> instance.  If
     * <code>obj</code> is an instance of <code>Team</code>, delegates to
     * <code>equals(Team)</code>.  Otherwise, returns <code>false</code>.
     *
     * @param  mixed   $obj The object to compare to.
     * @return boolean Whether equal to the object specified.
     */
    public function equals($obj)
    {
        if (!$obj instanceof static) {
            return false;
        }

        if ($this === $obj) {
            return true;
        }

        if (null === $this->getPrimaryKey() || null === $obj->getPrimaryKey()) {
            return false;
        }

        return $this->getPrimaryKey() === $obj->getPrimaryKey();
    }

    /**
     * Get the associative array of the virtual columns in this object
     *
     * @return array
     */
    public function getVirtualColumns()
    {
        return $this->virtualColumns;
    }

    /**
     * Checks the existence of a virtual column in this object
     *
     * @param  string  $name The virtual column name
     * @return boolean
     */
    public function hasVirtualColumn($name)
    {
        return array_key_exists($name, $this->virtualColumns);
    }

    /**
     * Get the value of a virtual column in this object
     *
     * @param  string $name The virtual column name
     * @return mixed
     *
     * @throws PropelException
     */
    public function getVirtualColumn($name)
    {
        if (!$this->hasVirtualColumn($name)) {
            throw new PropelException(sprintf('Cannot get value of inexistent virtual column %s.', $name));
        }

        return $this->virtualColumns[$name];
    }

    /**
     * Set the value of a virtual column in this object
     *
     * @param string $name  The virtual column name
     * @param mixed  $value The value to give to the virtual column
     *
     * @return $this|Team The current object, for fluid interface
     */
    public function setVirtualColumn($name, $value)
    {
        $this->virtualColumns[$name] = $value;

        return $this;
    }

    /**
     * Logs a message using Propel::log().
     *
     * @param  string  $msg
     * @param  int     $priority One of the Propel::LOG_* logging levels
     * @return boolean
     */
    protected function log($msg, $priority = Propel::LOG_INFO)
    {
        return Propel::log(get_class($this) . ': ' . $msg, $priority);
    }

    /**
     * Export the current object properties to a string, using a given parser format
     * <code>
     * $book = BookQuery::create()->findPk(9012);
     * echo $book->exportTo('JSON');
     *  => {"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param  mixed   $parser                 A AbstractParser instance, or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param  boolean $includeLazyLoadColumns (optional) Whether to include lazy load(ed) columns. Defaults to TRUE.
     * @return string  The exported data
     */
    public function exportTo($parser, $includeLazyLoadColumns = true)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        return $parser->fromArray($this->toArray(TableMap::TYPE_PHPNAME, $includeLazyLoadColumns, array(), true));
    }

    /**
     * Clean up internal collections prior to serializing
     * Avoids recursive loops that turn into segmentation faults when serializing
     */
    public function __sleep()
    {
        $this->clearAllReferences();

        $cls = new \ReflectionClass($this);
        $propertyNames = [];
        $serializableProperties = array_diff($cls->getProperties(), $cls->getProperties(\ReflectionProperty::IS_STATIC));

        foreach($serializableProperties as $property) {
            $propertyNames[] = $property->getName();
        }

        return $propertyNames;
    }

    /**
     * Get the [id] column value.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the [name] column value.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of [id] column.
     *
     * @param int $v new value
     * @return $this|\Team The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[TeamTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [name] column.
     *
     * @param string $v new value
     * @return $this|\Team The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[TeamTableMap::COL_NAME] = true;
        }

        return $this;
    } // setName()

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
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
     * @param array   $row       The row returned by DataFetcher->fetch().
     * @param int     $startcol  0-based offset column which indicates which restultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @param string  $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                  One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                            TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false, $indexType = TableMap::TYPE_NUM)
    {
        try {

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : TeamTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : TeamTableMap::translateFieldName('Name', TableMap::TYPE_PHPNAME, $indexType)];
            $this->name = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 2; // 2 = TeamTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Team'), 0, $e);
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
     * @throws PropelException
     */
    public function ensureConsistency()
    {
    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param      boolean $deep (optional) Whether to also de-associated any related objects.
     * @param      ConnectionInterface $con (optional) The ConnectionInterface connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(TeamTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildTeamQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collTeamTeamMembers = null;

            $this->collTeamMembers = null;
        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Team::setDeleted()
     * @see Team::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(TeamTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildTeamQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $this->setDeleted(true);
            }
        });
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see doSave()
     */
    public function save(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(TeamTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $isInsert = $this->isNew();
            $ret = $this->preSave($con);
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
                TeamTableMap::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }

            return $affectedRows;
        });
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see save()
     */
    protected function doSave(ConnectionInterface $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                    $affectedRows += 1;
                } else {
                    $affectedRows += $this->doUpdate($con);
                }
                $this->resetModified();
            }

            if ($this->teamMembersScheduledForDeletion !== null) {
                if (!$this->teamMembersScheduledForDeletion->isEmpty()) {
                    $pks = array();
                    foreach ($this->teamMembersScheduledForDeletion as $entry) {
                        $entryPk = [];

                        $entryPk[0] = $this->getId();
                        $entryPk[1] = $entry->getNumber();
                        $pks[] = $entryPk;
                    }

                    \TeamTeamMemberQuery::create()
                        ->filterByPrimaryKeys($pks)
                        ->delete($con);

                    $this->teamMembersScheduledForDeletion = null;
                }

            }

            if ($this->collTeamMembers) {
                foreach ($this->collTeamMembers as $teamMember) {
                    if (!$teamMember->isDeleted() && ($teamMember->isNew() || $teamMember->isModified())) {
                        $teamMember->save($con);
                    }
                }
            }


            if ($this->teamTeamMembersScheduledForDeletion !== null) {
                if (!$this->teamTeamMembersScheduledForDeletion->isEmpty()) {
                    \TeamTeamMemberQuery::create()
                        ->filterByPrimaryKeys($this->teamTeamMembersScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->teamTeamMembersScheduledForDeletion = null;
                }
            }

            if ($this->collTeamTeamMembers !== null) {
                foreach ($this->collTeamTeamMembers as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @throws PropelException
     * @see doSave()
     */
    protected function doInsert(ConnectionInterface $con)
    {
        $modifiedColumns = array();
        $index = 0;

        $this->modifiedColumns[TeamTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . TeamTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(TeamTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'ID';
        }
        if ($this->isColumnModified(TeamTableMap::COL_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'name';
        }

        $sql = sprintf(
            'INSERT INTO TEAM (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'ID':
                        $stmt->bindValue($identifier, $this->id, PDO::PARAM_INT);
                        break;
                    case 'name':
                        $stmt->bindValue($identifier, $this->name, PDO::PARAM_STR);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

        try {
            $pk = $con->lastInsertId();
        } catch (Exception $e) {
            throw new PropelException('Unable to get autoincrement id.', 0, $e);
        }
        $this->setId($pk);

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @return Integer Number of updated rows
     * @see doSave()
     */
    protected function doUpdate(ConnectionInterface $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();

        return $selectCriteria->doUpdate($valuesCriteria, $con);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param      string $name name
     * @param      string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return mixed Value of field.
     */
    public function getByName($name, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = TeamTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param      int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getId();
                break;
            case 1:
                return $this->getName();
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
     * @param     string  $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     *                    TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                    Defaults to TableMap::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to TRUE.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = TableMap::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {

        if (isset($alreadyDumpedObjects['Team'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Team'][$this->hashCode()] = true;
        $keys = TeamTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getName(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->collTeamTeamMembers) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'teamTeamMembers';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'TEAM_TEAM_MEMBERs';
                        break;
                    default:
                        $key = 'TeamTeamMembers';
                }

                $result[$key] = $this->collTeamTeamMembers->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param  string $name
     * @param  mixed  $value field value
     * @param  string $type The type of fieldname the $name is of:
     *                one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                Defaults to TableMap::TYPE_PHPNAME.
     * @return $this|\Team
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = TeamTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Team
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setName($value);
                break;
        } // switch()

        return $this;
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
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param      array  $arr     An array to populate the object from.
     * @param      string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = TableMap::TYPE_PHPNAME)
    {
        $keys = TeamTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setName($arr[$keys[1]]);
        }
    }

     /**
     * Populate the current object from a string, using a given parser format
     * <code>
     * $book = new Book();
     * $book->importFrom('JSON', '{"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param mixed $parser A AbstractParser instance,
     *                       or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param string $data The source data to import from
     * @param string $keyType The type of keys the array uses.
     *
     * @return $this|\Team The current object, for fluid interface
     */
    public function importFrom($parser, $data, $keyType = TableMap::TYPE_PHPNAME)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        $this->fromArray($parser->toArray($data), $keyType);

        return $this;
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(TeamTableMap::DATABASE_NAME);

        if ($this->isColumnModified(TeamTableMap::COL_ID)) {
            $criteria->add(TeamTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(TeamTableMap::COL_NAME)) {
            $criteria->add(TeamTableMap::COL_NAME, $this->name);
        }

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @throws LogicException if no primary key is defined
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = ChildTeamQuery::create();
        $criteria->add(TeamTableMap::COL_ID, $this->id);

        return $criteria;
    }

    /**
     * If the primary key is not null, return the hashcode of the
     * primary key. Otherwise, return the hash code of the object.
     *
     * @return int Hashcode
     */
    public function hashCode()
    {
        $validPk = null !== $this->getId();

        $validPrimaryKeyFKs = 0;
        $primaryKeyFKs = [];

        if ($validPk) {
            return crc32(json_encode($this->getPrimaryKey(), JSON_UNESCAPED_UNICODE));
        } elseif ($validPrimaryKeyFKs) {
            return crc32(json_encode($primaryKeyFKs, JSON_UNESCAPED_UNICODE));
        }

        return spl_object_hash($this);
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getId();
    }

    /**
     * Generic method to set the primary key (id column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \Team (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setName($this->getName());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getTeamTeamMembers() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addTeamTeamMember($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setId(NULL); // this is a auto-increment column, so set to default value
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param  boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return \Team Clone of current object.
     * @throws PropelException
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
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param      string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('TeamTeamMember' == $relationName) {
            return $this->initTeamTeamMembers();
        }
    }

    /**
     * Clears out the collTeamTeamMembers collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addTeamTeamMembers()
     */
    public function clearTeamTeamMembers()
    {
        $this->collTeamTeamMembers = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collTeamTeamMembers collection loaded partially.
     */
    public function resetPartialTeamTeamMembers($v = true)
    {
        $this->collTeamTeamMembersPartial = $v;
    }

    /**
     * Initializes the collTeamTeamMembers collection.
     *
     * By default this just sets the collTeamTeamMembers collection to an empty array (like clearcollTeamTeamMembers());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initTeamTeamMembers($overrideExisting = true)
    {
        if (null !== $this->collTeamTeamMembers && !$overrideExisting) {
            return;
        }

        $collectionClassName = TeamTeamMemberTableMap::getTableMap()->getCollectionClassName();

        $this->collTeamTeamMembers = new $collectionClassName;
        $this->collTeamTeamMembers->setModel('\TeamTeamMember');
    }

    /**
     * Gets an array of ChildTeamTeamMember objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildTeam is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildTeamTeamMember[] List of ChildTeamTeamMember objects
     * @throws PropelException
     */
    public function getTeamTeamMembers(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collTeamTeamMembersPartial && !$this->isNew();
        if (null === $this->collTeamTeamMembers || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collTeamTeamMembers) {
                // return empty collection
                $this->initTeamTeamMembers();
            } else {
                $collTeamTeamMembers = ChildTeamTeamMemberQuery::create(null, $criteria)
                    ->filterByTeam($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collTeamTeamMembersPartial && count($collTeamTeamMembers)) {
                        $this->initTeamTeamMembers(false);

                        foreach ($collTeamTeamMembers as $obj) {
                            if (false == $this->collTeamTeamMembers->contains($obj)) {
                                $this->collTeamTeamMembers->append($obj);
                            }
                        }

                        $this->collTeamTeamMembersPartial = true;
                    }

                    return $collTeamTeamMembers;
                }

                if ($partial && $this->collTeamTeamMembers) {
                    foreach ($this->collTeamTeamMembers as $obj) {
                        if ($obj->isNew()) {
                            $collTeamTeamMembers[] = $obj;
                        }
                    }
                }

                $this->collTeamTeamMembers = $collTeamTeamMembers;
                $this->collTeamTeamMembersPartial = false;
            }
        }

        return $this->collTeamTeamMembers;
    }

    /**
     * Sets a collection of ChildTeamTeamMember objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $teamTeamMembers A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildTeam The current object (for fluent API support)
     */
    public function setTeamTeamMembers(Collection $teamTeamMembers, ConnectionInterface $con = null)
    {
        /** @var ChildTeamTeamMember[] $teamTeamMembersToDelete */
        $teamTeamMembersToDelete = $this->getTeamTeamMembers(new Criteria(), $con)->diff($teamTeamMembers);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->teamTeamMembersScheduledForDeletion = clone $teamTeamMembersToDelete;

        foreach ($teamTeamMembersToDelete as $teamTeamMemberRemoved) {
            $teamTeamMemberRemoved->setTeam(null);
        }

        $this->collTeamTeamMembers = null;
        foreach ($teamTeamMembers as $teamTeamMember) {
            $this->addTeamTeamMember($teamTeamMember);
        }

        $this->collTeamTeamMembers = $teamTeamMembers;
        $this->collTeamTeamMembersPartial = false;

        return $this;
    }

    /**
     * Returns the number of related TeamTeamMember objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related TeamTeamMember objects.
     * @throws PropelException
     */
    public function countTeamTeamMembers(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collTeamTeamMembersPartial && !$this->isNew();
        if (null === $this->collTeamTeamMembers || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collTeamTeamMembers) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getTeamTeamMembers());
            }

            $query = ChildTeamTeamMemberQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByTeam($this)
                ->count($con);
        }

        return count($this->collTeamTeamMembers);
    }

    /**
     * Method called to associate a ChildTeamTeamMember object to this object
     * through the ChildTeamTeamMember foreign key attribute.
     *
     * @param  ChildTeamTeamMember $l ChildTeamTeamMember
     * @return $this|\Team The current object (for fluent API support)
     */
    public function addTeamTeamMember(ChildTeamTeamMember $l)
    {
        if ($this->collTeamTeamMembers === null) {
            $this->initTeamTeamMembers();
            $this->collTeamTeamMembersPartial = true;
        }

        if (!$this->collTeamTeamMembers->contains($l)) {
            $this->doAddTeamTeamMember($l);

            if ($this->teamTeamMembersScheduledForDeletion and $this->teamTeamMembersScheduledForDeletion->contains($l)) {
                $this->teamTeamMembersScheduledForDeletion->remove($this->teamTeamMembersScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildTeamTeamMember $teamTeamMember The ChildTeamTeamMember object to add.
     */
    protected function doAddTeamTeamMember(ChildTeamTeamMember $teamTeamMember)
    {
        $this->collTeamTeamMembers[]= $teamTeamMember;
        $teamTeamMember->setTeam($this);
    }

    /**
     * @param  ChildTeamTeamMember $teamTeamMember The ChildTeamTeamMember object to remove.
     * @return $this|ChildTeam The current object (for fluent API support)
     */
    public function removeTeamTeamMember(ChildTeamTeamMember $teamTeamMember)
    {
        if ($this->getTeamTeamMembers()->contains($teamTeamMember)) {
            $pos = $this->collTeamTeamMembers->search($teamTeamMember);
            $this->collTeamTeamMembers->remove($pos);
            if (null === $this->teamTeamMembersScheduledForDeletion) {
                $this->teamTeamMembersScheduledForDeletion = clone $this->collTeamTeamMembers;
                $this->teamTeamMembersScheduledForDeletion->clear();
            }
            $this->teamTeamMembersScheduledForDeletion[]= clone $teamTeamMember;
            $teamTeamMember->setTeam(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Team is new, it will return
     * an empty collection; or if this Team has previously
     * been saved, it will retrieve related TeamTeamMembers from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Team.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildTeamTeamMember[] List of ChildTeamTeamMember objects
     */
    public function getTeamTeamMembersJoinTeamMember(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildTeamTeamMemberQuery::create(null, $criteria);
        $query->joinWith('TeamMember', $joinBehavior);

        return $this->getTeamTeamMembers($query, $con);
    }

    /**
     * Clears out the collTeamMembers collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addTeamMembers()
     */
    public function clearTeamMembers()
    {
        $this->collTeamMembers = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Initializes the collTeamMembers crossRef collection.
     *
     * By default this just sets the collTeamMembers collection to an empty collection (like clearTeamMembers());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @return void
     */
    public function initTeamMembers()
    {
        $collectionClassName = TeamTeamMemberTableMap::getTableMap()->getCollectionClassName();

        $this->collTeamMembers = new $collectionClassName;
        $this->collTeamMembersPartial = true;
        $this->collTeamMembers->setModel('\TeamMember');
    }

    /**
     * Checks if the collTeamMembers collection is loaded.
     *
     * @return bool
     */
    public function isTeamMembersLoaded()
    {
        return null !== $this->collTeamMembers;
    }

    /**
     * Gets a collection of ChildTeamMember objects related by a many-to-many relationship
     * to the current object by way of the TEAM_TEAM_MEMBER cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildTeam is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return ObjectCollection|ChildTeamMember[] List of ChildTeamMember objects
     */
    public function getTeamMembers(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collTeamMembersPartial && !$this->isNew();
        if (null === $this->collTeamMembers || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collTeamMembers) {
                    $this->initTeamMembers();
                }
            } else {

                $query = ChildTeamMemberQuery::create(null, $criteria)
                    ->filterByTeam($this);
                $collTeamMembers = $query->find($con);
                if (null !== $criteria) {
                    return $collTeamMembers;
                }

                if ($partial && $this->collTeamMembers) {
                    //make sure that already added objects gets added to the list of the database.
                    foreach ($this->collTeamMembers as $obj) {
                        if (!$collTeamMembers->contains($obj)) {
                            $collTeamMembers[] = $obj;
                        }
                    }
                }

                $this->collTeamMembers = $collTeamMembers;
                $this->collTeamMembersPartial = false;
            }
        }

        return $this->collTeamMembers;
    }

    /**
     * Sets a collection of TeamMember objects related by a many-to-many relationship
     * to the current object by way of the TEAM_TEAM_MEMBER cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param  Collection $teamMembers A Propel collection.
     * @param  ConnectionInterface $con Optional connection object
     * @return $this|ChildTeam The current object (for fluent API support)
     */
    public function setTeamMembers(Collection $teamMembers, ConnectionInterface $con = null)
    {
        $this->clearTeamMembers();
        $currentTeamMembers = $this->getTeamMembers();

        $teamMembersScheduledForDeletion = $currentTeamMembers->diff($teamMembers);

        foreach ($teamMembersScheduledForDeletion as $toDelete) {
            $this->removeTeamMember($toDelete);
        }

        foreach ($teamMembers as $teamMember) {
            if (!$currentTeamMembers->contains($teamMember)) {
                $this->doAddTeamMember($teamMember);
            }
        }

        $this->collTeamMembersPartial = false;
        $this->collTeamMembers = $teamMembers;

        return $this;
    }

    /**
     * Gets the number of TeamMember objects related by a many-to-many relationship
     * to the current object by way of the TEAM_TEAM_MEMBER cross-reference table.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      boolean $distinct Set to true to force count distinct
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return int the number of related TeamMember objects
     */
    public function countTeamMembers(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collTeamMembersPartial && !$this->isNew();
        if (null === $this->collTeamMembers || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collTeamMembers) {
                return 0;
            } else {

                if ($partial && !$criteria) {
                    return count($this->getTeamMembers());
                }

                $query = ChildTeamMemberQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByTeam($this)
                    ->count($con);
            }
        } else {
            return count($this->collTeamMembers);
        }
    }

    /**
     * Associate a ChildTeamMember to this object
     * through the TEAM_TEAM_MEMBER cross reference table.
     *
     * @param ChildTeamMember $teamMember
     * @return ChildTeam The current object (for fluent API support)
     */
    public function addTeamMember(ChildTeamMember $teamMember)
    {
        if ($this->collTeamMembers === null) {
            $this->initTeamMembers();
        }

        if (!$this->getTeamMembers()->contains($teamMember)) {
            // only add it if the **same** object is not already associated
            $this->collTeamMembers->push($teamMember);
            $this->doAddTeamMember($teamMember);
        }

        return $this;
    }

    /**
     *
     * @param ChildTeamMember $teamMember
     */
    protected function doAddTeamMember(ChildTeamMember $teamMember)
    {
        $teamTeamMember = new ChildTeamTeamMember();

        $teamTeamMember->setTeamMember($teamMember);

        $teamTeamMember->setTeam($this);

        $this->addTeamTeamMember($teamTeamMember);

        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if (!$teamMember->isTeamsLoaded()) {
            $teamMember->initTeams();
            $teamMember->getTeams()->push($this);
        } elseif (!$teamMember->getTeams()->contains($this)) {
            $teamMember->getTeams()->push($this);
        }

    }

    /**
     * Remove teamMember of this object
     * through the TEAM_TEAM_MEMBER cross reference table.
     *
     * @param ChildTeamMember $teamMember
     * @return ChildTeam The current object (for fluent API support)
     */
    public function removeTeamMember(ChildTeamMember $teamMember)
    {
        if ($this->getTeamMembers()->contains($teamMember)) { $teamTeamMember = new ChildTeamTeamMember();

            $teamTeamMember->setTeamMember($teamMember);
            if ($teamMember->isTeamsLoaded()) {
                //remove the back reference if available
                $teamMember->getTeams()->removeObject($this);
            }

            $teamTeamMember->setTeam($this);
            $this->removeTeamTeamMember(clone $teamTeamMember);
            $teamTeamMember->clear();

            $this->collTeamMembers->remove($this->collTeamMembers->search($teamMember));

            if (null === $this->teamMembersScheduledForDeletion) {
                $this->teamMembersScheduledForDeletion = clone $this->collTeamMembers;
                $this->teamMembersScheduledForDeletion->clear();
            }

            $this->teamMembersScheduledForDeletion->push($teamMember);
        }


        return $this;
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        $this->id = null;
        $this->name = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references and back-references to other model objects or collections of model objects.
     *
     * This method is used to reset all php object references (not the actual reference in the database).
     * Necessary for object serialisation.
     *
     * @param      boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep) {
            if ($this->collTeamTeamMembers) {
                foreach ($this->collTeamTeamMembers as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collTeamMembers) {
                foreach ($this->collTeamMembers as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collTeamTeamMembers = null;
        $this->collTeamMembers = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(TeamTableMap::DEFAULT_STRING_FORMAT);
    }

    /**
     * Code to be run before persisting the object
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preSave(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after persisting the object
     * @param ConnectionInterface $con
     */
    public function postSave(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before inserting to database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preInsert(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after inserting to database
     * @param ConnectionInterface $con
     */
    public function postInsert(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before updating the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preUpdate(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after updating the object in database
     * @param ConnectionInterface $con
     */
    public function postUpdate(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before deleting the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preDelete(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after deleting the object in database
     * @param ConnectionInterface $con
     */
    public function postDelete(ConnectionInterface $con = null)
    {

    }


    /**
     * Derived method to catches calls to undefined methods.
     *
     * Provides magic import/export method support (fromXML()/toXML(), fromYAML()/toYAML(), etc.).
     * Allows to define default __call() behavior if you overwrite __call()
     *
     * @param string $name
     * @param mixed  $params
     *
     * @return array|string
     */
    public function __call($name, $params)
    {
        if (0 === strpos($name, 'get')) {
            $virtualColumn = substr($name, 3);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }

            $virtualColumn = lcfirst($virtualColumn);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }
        }

        if (0 === strpos($name, 'from')) {
            $format = substr($name, 4);

            return $this->importFrom($format, reset($params));
        }

        if (0 === strpos($name, 'to')) {
            $format = substr($name, 2);
            $includeLazyLoadColumns = isset($params[0]) ? $params[0] : true;

            return $this->exportTo($format, $includeLazyLoadColumns);
        }

        throw new BadMethodCallException(sprintf('Call to undefined method: %s.', $name));
    }

}
