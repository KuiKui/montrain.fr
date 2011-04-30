<?php

/**
 * Horaire form base class.
 *
 * @method Horaire getObject() Returns the current form's model object
 *
 * @package    montrain.fr
 * @subpackage form
 * @author     KuiKui
 */
abstract class BaseHoraireForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'trajet_id' => new sfWidgetFormPropelChoice(array('model' => 'Trajet', 'add_empty' => false)),
      'ligne_id'  => new sfWidgetFormPropelChoice(array('model' => 'Ligne', 'add_empty' => false)),
      'gare_id'   => new sfWidgetFormPropelChoice(array('model' => 'Gare', 'add_empty' => false)),
      'heure'     => new sfWidgetFormTime(),
      'id'        => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'trajet_id' => new sfValidatorPropelChoice(array('model' => 'Trajet', 'column' => 'id')),
      'ligne_id'  => new sfValidatorPropelChoice(array('model' => 'Ligne', 'column' => 'id')),
      'gare_id'   => new sfValidatorPropelChoice(array('model' => 'Gare', 'column' => 'id')),
      'heure'     => new sfValidatorTime(),
      'id'        => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('horaire[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Horaire';
  }


}
