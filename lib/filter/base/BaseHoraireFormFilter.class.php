<?php

/**
 * Horaire filter form base class.
 *
 * @package    montrain
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseHoraireFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'trajet_id' => new sfWidgetFormPropelChoice(array('model' => 'Trajet', 'add_empty' => true)),
      'ligne_id'  => new sfWidgetFormPropelChoice(array('model' => 'Ligne', 'add_empty' => true)),
      'gare_id'   => new sfWidgetFormPropelChoice(array('model' => 'Gare', 'add_empty' => true)),
      'heure'     => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'trajet_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Trajet', 'column' => 'id')),
      'ligne_id'  => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Ligne', 'column' => 'id')),
      'gare_id'   => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Gare', 'column' => 'id')),
      'heure'     => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('horaire_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Horaire';
  }

  public function getFields()
  {
    return array(
      'trajet_id' => 'ForeignKey',
      'ligne_id'  => 'ForeignKey',
      'gare_id'   => 'ForeignKey',
      'heure'     => 'Date',
      'id'        => 'Number',
    );
  }
}
