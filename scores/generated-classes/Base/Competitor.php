<?php

namespace Base;

use \Competitor as ChildCompetitor;
use \CompetitorCompetitorresults as ChildCompetitorCompetitorresults;
use \CompetitorCompetitorresultsQuery as ChildCompetitorCompetitorresultsQuery;
use \CompetitorQuery as ChildCompetitorQuery;
use \MeetCompetitor as ChildMeetCompetitor;
use \MeetCompetitorQuery as ChildMeetCompetitorQuery;
use \Exception;
use \PDO;
use Map\CompetitorCompetitorresultsTableMap;
use Map\CompetitorTableMap;
use Map\MeetCompetitorTableMap;
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
 * Base class that represents a row from the 'competitor' table.
 *
 *
 *
* @package    propel.generator..Base
*/
abstract class Competitor implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\CompetitorTableMap';


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
     * The value for the category field.
     *
     * @var        string
     */
    protected $category;

    /**
     * The value for the name field.
     *
     * @var        string
     */
    protected $name;

    /**
     * The value for the number field.
     *
     * @var        string
     */
    protected $number;

    /**
     * The value for the team field.
     *
     * @var        string
     */
    protected $team;

    /**
     * @var        ObjectCollection|ChildCompetitorCompetitorresults[] Collection to store aggregation of ChildCompetitorCompetitorresults objects.
     */
    protected $collCompetitorCompetitorresultss;
    protected $collCompetitorCompetitorresultssPartial;

    /**
     * @var        ObjectCollection|ChildMeetCompetitor[] Collection to store aggregation of ChildMeetCompetitor objects.
     */
    protected $collMeetCompetitors;
    protected $collMeetCompetitorsPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildCompetitorCompetitorresults[]
     */
    protected $competitorCompetitorresultssScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildMeetCompetitor[]
     */
    protected $meetCompetitorsScheduledForDeletion = null;

    /**
     * Initializes internal state of Base\Competitor object.
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
     * Compares this with another <code>Competitor</code> instance.  If
     * <code>obj</code> is an instance of <code>Competitor</code>, delegates to
     * <code>equals(Competitor)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Competitor The current object, for fluid interface
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
     * Get the [category] column value.
     *
     * @return string
     */
    public function getCategory()
    {
        return $this->category;
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
     * Get the [number] column value.
     *
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Get the [team] column value.
     *
     * @return string
     */
    public function getTeam()
    {
        return $this->team;
    }

    /**
     * Set the value of [id] column.
     *
     * @param int $v new value
     * @return $this|\Competitor The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[CompetitorTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [category] column.
     *
     * @param string $v new value
     * @return $this|\Competitor The current object (for fluent API support)
     */
    public function setCategory($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->category !== $v) {
            $this->category = $v;
            $this->modifiedColumns[CompetitorTableMap::COL_CATEGORY] = true;
        }

        return $this;
    } // setCategory()

    /**
     * Set the value of [name] column.
     *
     * @param string $v new value
     * @return $this|\Competitor The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[CompetitorTableMap::COL_NAME] = true;
        }

        return $this;
    } // setName()

    /**
     * Set the value of [number] column.
     *
     * @param string $v new value
     * @return $this|\Competitor The current object (for fluent API support)
     */
    public function setNumber($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->number !== $v) {
            $this->number = $v;
            $this->modifiedColumns[CompetitorTableMap::COL_NUMBER] = true;
        }

        return $this;
    } // setNumber()

    /**
     * Set the value of [team] column.
     *
     * @param string $v new value
     * @return $this|\Competitor The current object (for fluent API support)
     */
    public function setTeam($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->team !== $v) {
            $this->team = $v;
            $this->modifiedColumns[CompetitorTableMap::COL_TEAM] = true;
        }

        return $this;
    } // setTeam()

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : CompetitorTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : CompetitorTableMap::translateFieldName('Category', TableMap::TYPE_PHPNAME, $indexType)];
            $this->category = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : CompetitorTableMap::translateFieldName('Name', TableMap::TYPE_PHPNAME, $indexType)];
            $this->name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : CompetitorTableMap::translateFieldName('Number', TableMap::TYPE_PHPNAME, $indexType)];
            $this->number = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : CompetitorTableMap::translateFieldName('Team', TableMap::TYPE_PHPNAME, $indexType)];
            $this->team = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 5; // 5 = CompetitorTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Competitor'), 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(CompetitorTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildCompetitorQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collCompetitorCompetitorresultss = null;

            $this->collMeetCompetitors = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Competitor::setDeleted()
     * @see Competitor::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(CompetitorTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildCompetitorQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(CompetitorTableMap::DATABASE_NAME);
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
                CompetitorTableMap::addInstanceToPool($this);
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

            if ($this->competitorCompetitorresultssScheduledForDeletion !== null) {
                if (!$this->competitorCompetitorresultssScheduledForDeletion->isEmpty()) {
                    \CompetitorCompetitorresultsQuery::create()
                        ->filterByPrimaryKeys($this->competitorCompetitorresultssScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->competitorCompetitorresultssScheduledForDeletion = null;
                }
            }

            if ($this->collCompetitorCompetitorresultss !== null) {
                foreach ($this->collCompetitorCompetitorresultss as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->meetCompetitorsScheduledForDeletion !== null) {
                if (!$this->meetCompetitorsScheduledForDeletion->isEmpty()) {
                    \MeetCompetitorQuery::create()
                        ->filterByPrimaryKeys($this->meetCompetitorsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->meetCompetitorsScheduledForDeletion = null;
                }
            }

            if ($this->collMeetCompetitors !== null) {
                foreach ($this->collMeetCompetitors as $referrerFK) {
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

        $this->modifiedColumns[CompetitorTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . CompetitorTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(CompetitorTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'ID';
        }
        if ($this->isColumnModified(CompetitorTableMap::COL_CATEGORY)) {
            $modifiedColumns[':p' . $index++]  = 'category';
        }
        if ($this->isColumnModified(CompetitorTableMap::COL_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'name';
        }
        if ($this->isColumnModified(CompetitorTableMap::COL_NUMBER)) {
            $modifiedColumns[':p' . $index++]  = 'number';
        }
        if ($this->isColumnModified(CompetitorTableMap::COL_TEAM)) {
            $modifiedColumns[':p' . $index++]  = 'team';
        }

        $sql = sprintf(
            'INSERT INTO competitor (%s) VALUES (%s)',
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
                    case 'category':
                        $stmt->bindValue($identifier, $this->category, PDO::PARAM_STR);
                        break;
                    case 'name':
                        $stmt->bindValue($identifier, $this->name, PDO::PARAM_STR);
                        break;
                    case 'number':
                        $stmt->bindValue($identifier, $this->number, PDO::PARAM_STR);
                        break;
                    case 'team':
                        $stmt->bindValue($identifier, $this->team, PDO::PARAM_STR);
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
        $pos = CompetitorTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getCategory();
                break;
            case 2:
                return $this->getName();
                break;
            case 3:
                return $this->getNumber();
                break;
            case 4:
                return $this->getTeam();
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

        if (isset($alreadyDumpedObjects['Competitor'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Competitor'][$this->hashCode()] = true;
        $keys = CompetitorTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getCategory(),
            $keys[2] => $this->getName(),
            $keys[3] => $this->getNumber(),
            $keys[4] => $this->getTeam(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->collCompetitorCompetitorresultss) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'competitorCompetitorresultss';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'competitor_competitorresultss';
                        break;
                    default:
                        $key = 'CompetitorCompetitorresultss';
                }

                $result[$key] = $this->collCompetitorCompetitorresultss->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collMeetCompetitors) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'meetCompetitors';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'meet_competitors';
                        break;
                    default:
                        $key = 'MeetCompetitors';
                }

                $result[$key] = $this->collMeetCompetitors->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\Competitor
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = CompetitorTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Competitor
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setCategory($value);
                break;
            case 2:
                $this->setName($value);
                break;
            case 3:
                $this->setNumber($value);
                break;
            case 4:
                $this->setTeam($value);
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
        $keys = CompetitorTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setCategory($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setName($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setNumber($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setTeam($arr[$keys[4]]);
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
     * @return $this|\Competitor The current object, for fluid interface
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
        $criteria = new Criteria(CompetitorTableMap::DATABASE_NAME);

        if ($this->isColumnModified(CompetitorTableMap::COL_ID)) {
            $criteria->add(CompetitorTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(CompetitorTableMap::COL_CATEGORY)) {
            $criteria->add(CompetitorTableMap::COL_CATEGORY, $this->category);
        }
        if ($this->isColumnModified(CompetitorTableMap::COL_NAME)) {
            $criteria->add(CompetitorTableMap::COL_NAME, $this->name);
        }
        if ($this->isColumnModified(CompetitorTableMap::COL_NUMBER)) {
            $criteria->add(CompetitorTableMap::COL_NUMBER, $this->number);
        }
        if ($this->isColumnModified(CompetitorTableMap::COL_TEAM)) {
            $criteria->add(CompetitorTableMap::COL_TEAM, $this->team);
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
        $criteria = ChildCompetitorQuery::create();
        $criteria->add(CompetitorTableMap::COL_ID, $this->id);

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
     * @param      object $copyObj An object of \Competitor (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setCategory($this->getCategory());
        $copyObj->setName($this->getName());
        $copyObj->setNumber($this->getNumber());
        $copyObj->setTeam($this->getTeam());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getCompetitorCompetitorresultss() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addCompetitorCompetitorresults($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getMeetCompetitors() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addMeetCompetitor($relObj->copy($deepCopy));
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
     * @return \Competitor Clone of current object.
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
        if ('CompetitorCompetitorresults' == $relationName) {
            return $this->initCompetitorCompetitorresultss();
        }
        if ('MeetCompetitor' == $relationName) {
            return $this->initMeetCompetitors();
        }
    }

    /**
     * Clears out the collCompetitorCompetitorresultss collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addCompetitorCompetitorresultss()
     */
    public function clearCompetitorCompetitorresultss()
    {
        $this->collCompetitorCompetitorresultss = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collCompetitorCompetitorresultss collection loaded partially.
     */
    public function resetPartialCompetitorCompetitorresultss($v = true)
    {
        $this->collCompetitorCompetitorresultssPartial = $v;
    }

    /**
     * Initializes the collCompetitorCompetitorresultss collection.
     *
     * By default this just sets the collCompetitorCompetitorresultss collection to an empty array (like clearcollCompetitorCompetitorresultss());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initCompetitorCompetitorresultss($overrideExisting = true)
    {
        if (null !== $this->collCompetitorCompetitorresultss && !$overrideExisting) {
            return;
        }

        $collectionClassName = CompetitorCompetitorresultsTableMap::getTableMap()->getCollectionClassName();

        $this->collCompetitorCompetitorresultss = new $collectionClassName;
        $this->collCompetitorCompetitorresultss->setModel('\CompetitorCompetitorresults');
    }

    /**
     * Gets an array of ChildCompetitorCompetitorresults objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildCompetitor is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildCompetitorCompetitorresults[] List of ChildCompetitorCompetitorresults objects
     * @throws PropelException
     */
    public function getCompetitorCompetitorresultss(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collCompetitorCompetitorresultssPartial && !$this->isNew();
        if (null === $this->collCompetitorCompetitorresultss || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collCompetitorCompetitorresultss) {
                // return empty collection
                $this->initCompetitorCompetitorresultss();
            } else {
                $collCompetitorCompetitorresultss = ChildCompetitorCompetitorresultsQuery::create(null, $criteria)
                    ->filterByCompetitor($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collCompetitorCompetitorresultssPartial && count($collCompetitorCompetitorresultss)) {
                        $this->initCompetitorCompetitorresultss(false);

                        foreach ($collCompetitorCompetitorresultss as $obj) {
                            if (false == $this->collCompetitorCompetitorresultss->contains($obj)) {
                                $this->collCompetitorCompetitorresultss->append($obj);
                            }
                        }

                        $this->collCompetitorCompetitorresultssPartial = true;
                    }

                    return $collCompetitorCompetitorresultss;
                }

                if ($partial && $this->collCompetitorCompetitorresultss) {
                    foreach ($this->collCompetitorCompetitorresultss as $obj) {
                        if ($obj->isNew()) {
                            $collCompetitorCompetitorresultss[] = $obj;
                        }
                    }
                }

                $this->collCompetitorCompetitorresultss = $collCompetitorCompetitorresultss;
                $this->collCompetitorCompetitorresultssPartial = false;
            }
        }

        return $this->collCompetitorCompetitorresultss;
    }

    /**
     * Sets a collection of ChildCompetitorCompetitorresults objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $competitorCompetitorresultss A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildCompetitor The current object (for fluent API support)
     */
    public function setCompetitorCompetitorresultss(Collection $competitorCompetitorresultss, ConnectionInterface $con = null)
    {
        /** @var ChildCompetitorCompetitorresults[] $competitorCompetitorresultssToDelete */
        $competitorCompetitorresultssToDelete = $this->getCompetitorCompetitorresultss(new Criteria(), $con)->diff($competitorCompetitorresultss);


        $this->competitorCompetitorresultssScheduledForDeletion = $competitorCompetitorresultssToDelete;

        foreach ($competitorCompetitorresultssToDelete as $competitorCompetitorresultsRemoved) {
            $competitorCompetitorresultsRemoved->setCompetitor(null);
        }

        $this->collCompetitorCompetitorresultss = null;
        foreach ($competitorCompetitorresultss as $competitorCompetitorresults) {
            $this->addCompetitorCompetitorresults($competitorCompetitorresults);
        }

        $this->collCompetitorCompetitorresultss = $competitorCompetitorresultss;
        $this->collCompetitorCompetitorresultssPartial = false;

        return $this;
    }

    /**
     * Returns the number of related CompetitorCompetitorresults objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related CompetitorCompetitorresults objects.
     * @throws PropelException
     */
    public function countCompetitorCompetitorresultss(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collCompetitorCompetitorresultssPartial && !$this->isNew();
        if (null === $this->collCompetitorCompetitorresultss || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collCompetitorCompetitorresultss) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getCompetitorCompetitorresultss());
            }

            $query = ChildCompetitorCompetitorresultsQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCompetitor($this)
                ->count($con);
        }

        return count($this->collCompetitorCompetitorresultss);
    }

    /**
     * Method called to associate a ChildCompetitorCompetitorresults object to this object
     * through the ChildCompetitorCompetitorresults foreign key attribute.
     *
     * @param  ChildCompetitorCompetitorresults $l ChildCompetitorCompetitorresults
     * @return $this|\Competitor The current object (for fluent API support)
     */
    public function addCompetitorCompetitorresults(ChildCompetitorCompetitorresults $l)
    {
        if ($this->collCompetitorCompetitorresultss === null) {
            $this->initCompetitorCompetitorresultss();
            $this->collCompetitorCompetitorresultssPartial = true;
        }

        if (!$this->collCompetitorCompetitorresultss->contains($l)) {
            $this->doAddCompetitorCompetitorresults($l);

            if ($this->competitorCompetitorresultssScheduledForDeletion and $this->competitorCompetitorresultssScheduledForDeletion->contains($l)) {
                $this->competitorCompetitorresultssScheduledForDeletion->remove($this->competitorCompetitorresultssScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildCompetitorCompetitorresults $competitorCompetitorresults The ChildCompetitorCompetitorresults object to add.
     */
    protected function doAddCompetitorCompetitorresults(ChildCompetitorCompetitorresults $competitorCompetitorresults)
    {
        $this->collCompetitorCompetitorresultss[]= $competitorCompetitorresults;
        $competitorCompetitorresults->setCompetitor($this);
    }

    /**
     * @param  ChildCompetitorCompetitorresults $competitorCompetitorresults The ChildCompetitorCompetitorresults object to remove.
     * @return $this|ChildCompetitor The current object (for fluent API support)
     */
    public function removeCompetitorCompetitorresults(ChildCompetitorCompetitorresults $competitorCompetitorresults)
    {
        if ($this->getCompetitorCompetitorresultss()->contains($competitorCompetitorresults)) {
            $pos = $this->collCompetitorCompetitorresultss->search($competitorCompetitorresults);
            $this->collCompetitorCompetitorresultss->remove($pos);
            if (null === $this->competitorCompetitorresultssScheduledForDeletion) {
                $this->competitorCompetitorresultssScheduledForDeletion = clone $this->collCompetitorCompetitorresultss;
                $this->competitorCompetitorresultssScheduledForDeletion->clear();
            }
            $this->competitorCompetitorresultssScheduledForDeletion[]= clone $competitorCompetitorresults;
            $competitorCompetitorresults->setCompetitor(null);
        }

        return $this;
    }

    /**
     * Clears out the collMeetCompetitors collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addMeetCompetitors()
     */
    public function clearMeetCompetitors()
    {
        $this->collMeetCompetitors = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collMeetCompetitors collection loaded partially.
     */
    public function resetPartialMeetCompetitors($v = true)
    {
        $this->collMeetCompetitorsPartial = $v;
    }

    /**
     * Initializes the collMeetCompetitors collection.
     *
     * By default this just sets the collMeetCompetitors collection to an empty array (like clearcollMeetCompetitors());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initMeetCompetitors($overrideExisting = true)
    {
        if (null !== $this->collMeetCompetitors && !$overrideExisting) {
            return;
        }

        $collectionClassName = MeetCompetitorTableMap::getTableMap()->getCollectionClassName();

        $this->collMeetCompetitors = new $collectionClassName;
        $this->collMeetCompetitors->setModel('\MeetCompetitor');
    }

    /**
     * Gets an array of ChildMeetCompetitor objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildCompetitor is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildMeetCompetitor[] List of ChildMeetCompetitor objects
     * @throws PropelException
     */
    public function getMeetCompetitors(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collMeetCompetitorsPartial && !$this->isNew();
        if (null === $this->collMeetCompetitors || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collMeetCompetitors) {
                // return empty collection
                $this->initMeetCompetitors();
            } else {
                $collMeetCompetitors = ChildMeetCompetitorQuery::create(null, $criteria)
                    ->filterByCompetitor($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collMeetCompetitorsPartial && count($collMeetCompetitors)) {
                        $this->initMeetCompetitors(false);

                        foreach ($collMeetCompetitors as $obj) {
                            if (false == $this->collMeetCompetitors->contains($obj)) {
                                $this->collMeetCompetitors->append($obj);
                            }
                        }

                        $this->collMeetCompetitorsPartial = true;
                    }

                    return $collMeetCompetitors;
                }

                if ($partial && $this->collMeetCompetitors) {
                    foreach ($this->collMeetCompetitors as $obj) {
                        if ($obj->isNew()) {
                            $collMeetCompetitors[] = $obj;
                        }
                    }
                }

                $this->collMeetCompetitors = $collMeetCompetitors;
                $this->collMeetCompetitorsPartial = false;
            }
        }

        return $this->collMeetCompetitors;
    }

    /**
     * Sets a collection of ChildMeetCompetitor objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $meetCompetitors A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildCompetitor The current object (for fluent API support)
     */
    public function setMeetCompetitors(Collection $meetCompetitors, ConnectionInterface $con = null)
    {
        /** @var ChildMeetCompetitor[] $meetCompetitorsToDelete */
        $meetCompetitorsToDelete = $this->getMeetCompetitors(new Criteria(), $con)->diff($meetCompetitors);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->meetCompetitorsScheduledForDeletion = clone $meetCompetitorsToDelete;

        foreach ($meetCompetitorsToDelete as $meetCompetitorRemoved) {
            $meetCompetitorRemoved->setCompetitor(null);
        }

        $this->collMeetCompetitors = null;
        foreach ($meetCompetitors as $meetCompetitor) {
            $this->addMeetCompetitor($meetCompetitor);
        }

        $this->collMeetCompetitors = $meetCompetitors;
        $this->collMeetCompetitorsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related MeetCompetitor objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related MeetCompetitor objects.
     * @throws PropelException
     */
    public function countMeetCompetitors(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collMeetCompetitorsPartial && !$this->isNew();
        if (null === $this->collMeetCompetitors || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collMeetCompetitors) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getMeetCompetitors());
            }

            $query = ChildMeetCompetitorQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCompetitor($this)
                ->count($con);
        }

        return count($this->collMeetCompetitors);
    }

    /**
     * Method called to associate a ChildMeetCompetitor object to this object
     * through the ChildMeetCompetitor foreign key attribute.
     *
     * @param  ChildMeetCompetitor $l ChildMeetCompetitor
     * @return $this|\Competitor The current object (for fluent API support)
     */
    public function addMeetCompetitor(ChildMeetCompetitor $l)
    {
        if ($this->collMeetCompetitors === null) {
            $this->initMeetCompetitors();
            $this->collMeetCompetitorsPartial = true;
        }

        if (!$this->collMeetCompetitors->contains($l)) {
            $this->doAddMeetCompetitor($l);

            if ($this->meetCompetitorsScheduledForDeletion and $this->meetCompetitorsScheduledForDeletion->contains($l)) {
                $this->meetCompetitorsScheduledForDeletion->remove($this->meetCompetitorsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildMeetCompetitor $meetCompetitor The ChildMeetCompetitor object to add.
     */
    protected function doAddMeetCompetitor(ChildMeetCompetitor $meetCompetitor)
    {
        $this->collMeetCompetitors[]= $meetCompetitor;
        $meetCompetitor->setCompetitor($this);
    }

    /**
     * @param  ChildMeetCompetitor $meetCompetitor The ChildMeetCompetitor object to remove.
     * @return $this|ChildCompetitor The current object (for fluent API support)
     */
    public function removeMeetCompetitor(ChildMeetCompetitor $meetCompetitor)
    {
        if ($this->getMeetCompetitors()->contains($meetCompetitor)) {
            $pos = $this->collMeetCompetitors->search($meetCompetitor);
            $this->collMeetCompetitors->remove($pos);
            if (null === $this->meetCompetitorsScheduledForDeletion) {
                $this->meetCompetitorsScheduledForDeletion = clone $this->collMeetCompetitors;
                $this->meetCompetitorsScheduledForDeletion->clear();
            }
            $this->meetCompetitorsScheduledForDeletion[]= clone $meetCompetitor;
            $meetCompetitor->setCompetitor(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Competitor is new, it will return
     * an empty collection; or if this Competitor has previously
     * been saved, it will retrieve related MeetCompetitors from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Competitor.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildMeetCompetitor[] List of ChildMeetCompetitor objects
     */
    public function getMeetCompetitorsJoinMeet(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildMeetCompetitorQuery::create(null, $criteria);
        $query->joinWith('Meet', $joinBehavior);

        return $this->getMeetCompetitors($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        $this->id = null;
        $this->category = null;
        $this->name = null;
        $this->number = null;
        $this->team = null;
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
            if ($this->collCompetitorCompetitorresultss) {
                foreach ($this->collCompetitorCompetitorresultss as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collMeetCompetitors) {
                foreach ($this->collMeetCompetitors as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collCompetitorCompetitorresultss = null;
        $this->collMeetCompetitors = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(CompetitorTableMap::DEFAULT_STRING_FORMAT);
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
