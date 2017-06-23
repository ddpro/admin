<?php
namespace DDPro\Admin\Fields;

use DDPro\Admin\Includes\CustomMultup;
use DDPro\Admin\Includes\Multup;

class Image extends File
{

    /**
     * The specific defaults for the image class
     *
     * @var array
     */
    protected $imageDefaults = [
        'sizes' => [],
    ];

    /**
     * The specific rules for the image class
     *
     * @var array
     */
    protected $imageRules = [
        'sizes' => 'array',
    ];

    /**
     * This function is used to perform the actual upload and resizing using the CustomMultup class
     *
     * @return array
     */
    public function doUpload()
    {
        // open parameters:
        // $input, $rules, $path, $random = true
        /** @var CustomMultup $multup */
        $multup = CustomMultup::open(
            $this->getOption('field_name'),
            null,
            $this->getOption('location'),
            $this->getOption('naming') === 'random'
        );

        /** @var array $result */
        $result = $multup
            ->sizes($this->getOption('sizes'))
            ->set_length($this->getOption('length'))
            ->upload();

        // FIXME: The upload_image() function in CustomMultup is currently broken and
        // returns a string rather than an array, and that needs to be fixed.  $result[0]
        // here should be an array.
        return $result[0];
    }

    /**
     * Gets all rules
     *
     * @return array
     */
    public function getRules()
    {
        $rules = parent::getRules();

        return array_merge($rules, $this->imageRules);
    }

    /**
     * Gets all default values
     *
     * @return array
     */
    public function getDefaults()
    {
        $defaults = parent::getDefaults();

        return array_merge($defaults, $this->imageDefaults);
    }
}
