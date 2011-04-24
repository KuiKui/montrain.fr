<?php

/**
 * LigneGare form base class.
 *
 * @method LigneGare getObject() Returns the current form's model object
 *
 * @package    montrain
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseLigneGareForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'ligne_id' => new sfWidgetFormInputHidden(),
      'gare_id'  => new sfWidgetFormInputHidden(),
      'valide'   => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'ligne_id' => new sfValidatorPropelChoice(array('model' => 'Ligne', 'column' => 'id', 'required' => false)),
      'gare_id'  => new sfValidatorPropelChoice(array('model' => 'Gare', 'column' => 'id', 'required' => false)),
      'valide'   => new sfValidatorBoolean(),
    ));

    $this->widgetSchema->setNameFormat('ligne_gare[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'LigneGare';
  }


}
