<?php

/**
 * Message form base class.
 *
 * @method Message getObject() Returns the current form's model object
 *
 * @package    montrain.fr
 * @subpackage form
 * @author     KuiKui
 */
abstract class BaseMessageForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'            => new sfWidgetFormInputHidden(),
      'discussion_id' => new sfWidgetFormPropelChoice(array('model' => 'Discussion', 'add_empty' => false)),
      'contenu'       => new sfWidgetFormInputText(),
      'valide'        => new sfWidgetFormInputCheckbox(),
      'created_at'    => new sfWidgetFormDateTime(),
      'updated_at'    => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'            => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'discussion_id' => new sfValidatorPropelChoice(array('model' => 'Discussion', 'column' => 'id')),
      'contenu'       => new sfValidatorString(array('max_length' => 255)),
      'valide'        => new sfValidatorBoolean(),
      'created_at'    => new sfValidatorDateTime(array('required' => false)),
      'updated_at'    => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('message[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Message';
  }


}
