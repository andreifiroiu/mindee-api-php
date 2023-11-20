<?php

namespace Mindee\Parsing\Common;

use Mindee\Error\MindeeApiException;

abstract class Inference
{
    public Product $product;
    /**
     * Name of the product's endpoint.
     */
    public static string $endpoint_name;
    /**
     * Version of the product's endpoint.
     */
    public static string $endpoint_version;
    /**
     * Prediction.
     */
    public Prediction $prediction;
    /**
     * Array of pages.
     *
     * @see Page
     */
    public array $pages;
    /**
     * Whether the document has had any rotation applied to it.
     */
    public ?bool $isRotationApplied;
    /**
     * Optional page id for page-level predictions.
     */
    public ?int $pageId;

    public function __construct(array $raw_prediction, ?int $page_id = null)
    {
        $this->isRotationApplied = null;
        if (array_key_exists('is_rotation_applied', $raw_prediction)) {
            $this->isRotationApplied = $raw_prediction['is_rotation_applied'];
        }
        $this->product = new Product($raw_prediction['product']);
        if (isset($page_id)) {
            $this->pageId = $page_id;
        }
    }


    public function __toString(): string
    {
        $rotation_applied = $this->isRotationApplied ? 'Yes' : 'No';
        $pages = $this->pages ? "\n" . implode('\n', $this->pages) : '';

        return "Inference
#########
:Product: $this->product
:Rotation applied: $rotation_applied

Prediction
==========
$this->prediction
$pages
";
    }
}