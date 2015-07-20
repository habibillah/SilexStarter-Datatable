<?php

namespace Xsanisty\Datatable;

use Exception;
use Illuminate\Database\Schema\Builder as SchemaBuilder;
use LiveControl\EloquentDataTable\DataTable;

class DatatableResponseBuilder
{
    protected $model;
    protected $schema;
    protected $column;
    protected $formatter;

    public function __construct(SchemaBuilder $schema)
    {
        $this->schema = $schema;
    }

    /**
     * Set the column to be rendered
     * @param array $column list of column need to be rendered
     */
    public function setColumn(array $column)
    {
        $this->column = $column;

        return $this;
    }

    /**
     * Get the column list
     * @return  array List of column
     */
    public function getColumn()
    {
        if ($this->column) {
            return $this->column;
        }

        return $this->schema->getColumnListing($this->getModel()->getTable());
    }

    /**
     * Set the model of related table
     * @param Illuminate\Database\Eloquent\Model $model
     */
    public function setModel($model)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Get the model instance
     * @return Illuminate\Database\Eloquent\Model
     */
    public function getModel()
    {
        if (!$this->model) {
            throw new Exception("Model must be set before creating datatable response", 1);
        }

        return $this->model;
    }

    /**
     * Set the column formatter
     * @param callable $formatter the column formatter
     */
    public function setFormatter(callable $formatter)
    {
        $this->formatter = $formatter;

        return $this;
    }

    /**
     * Get the column formatter
     * @return callable
     */
    public function getFormatter()
    {
        return $this->formatter;
    }

    /**
     * an alias of setModel
     * @param  Illuminate\Database\Eloquent\Model $model
     */
    public function of($model)
    {
        return $this->setModel($model);
    }

    /**
     * Make an array formatted for datatable response
     * @return array
     */
    public function make()
    {
        return $this->datatableFactory()->make();
    }

    protected function datatableFactory()
    {
        return new DataTable($this->model, $this->column);
    }
}
