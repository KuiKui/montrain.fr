<?php

/**
 * Discussion form base class.
 *
 * @method Discussion getObject() Returns the current form's model object
 *
 * @package    montrain
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseDiscussionForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'             => new sfWidgetFormInputHidden(),
      'ligne_id'       => new sfWidgetFormPropelChoice(array('model' => 'Ligne', 'add_empty' => false)),
      'nom'            => new sfWidgetFormInputText(),
      'nombre_message' => new sfWidgetFormInputText(),
      'importante'     => new sfWidgetFormInputCheckbox(),
      'valide'         => new sfWidgetFormInputCheckbox(),
      'created_at'     => new sfWidgetFormDateTime(),
      'updated_at'     => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'             => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'ligne_id'       => new sfValidatorPropelChoice(array('model' => 'Ligne', 'column' => 'id')),
      'nom'            => new sfValidatorString(array('max_length' => 255)),
      'nombre_message' => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'importante'     => new sfValidatorBoolean(),
      'valide'         => new sfValidatorBoolean(),
      'created_at'     => new sfValidatorDateTime(array('required' => false)),
      'updated_at'     => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorPropelUnique(array('model' => 'Discussion', 'column' => array('nom')))
    );

    $this->widgetSchema->setNameFormat('discussion[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Discussion';
  }


}
