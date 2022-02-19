<?php


namespace App\Models\Parameters;

use Illuminate\Support\Str;

trait RelatedToAnotherModel
{
    /**
     * Get related model short name
     *
     * @return false|string
     */
    protected function getRelatedModelShortName()
    {
        $class_name = (new \ReflectionClass(self::class))->getShortName();
        return substr($class_name, 8);
    }

    /**
     * Get related model name
     *
     * @return string
     */
    protected function relatedModel()
    {
        return 'App\Models\\' . $this->getRelatedModelShortName();
    }

    /**
     * Get related model instance
     *
     * @return mixed
     */
    public function value()
    {
        return $this->belongsTo($this->relatedModel(),
            strtolower(Str::snake($this->getRelatedModelShortName()) . '_id'));
    }
}
