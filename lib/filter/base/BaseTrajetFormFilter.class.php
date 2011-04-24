<?php

/**
 * Trajet filter form base class.
 *
 * @package    montrain
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseTrajetFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'discussion_id' => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'discussion_id' => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('trajet_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Trajet';
  }

  public function getFields()
  {
    return array(
      'id'            => 'Number',
      'discussion_id' => 'Text',
    );
  }
}
