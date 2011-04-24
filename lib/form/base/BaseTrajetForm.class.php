<?php

/**
 * Trajet form base class.
 *
 * @method Trajet getObject() Returns the current form's model object
 *
 * @package    montrain
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseTrajetForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'            => new sfWidgetFormInputHidden(),
      'discussion_id' => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'            => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'discussion_id' => new sfValidatorString(array('max_length' => 8)),
    ));

    $this->widgetSchema->setNameFormat('trajet[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Trajet';
  }


}
