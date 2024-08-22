<?php

class ProductCatalog
{
    use Model;

    protected $table = 'productcatalog'; // Assuming your table is named 'product_catalog'

    public $description;

    /**
     * Save the current model instance to the database.
     *
     * @return bool
     */
    public function save()
    {
        // Prepare data for insertion
        $data = [
            'description' => $this->description,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        // Insert data into the table
        return $this->insert($data);
    }
}
