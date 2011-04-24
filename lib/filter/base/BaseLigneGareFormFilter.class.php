<?php

/**
 * LigneGare filter form base class.
 *
 * @package    montrain
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseLigneGareFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'valide'   => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
    ));

    $this->setValidators(array(
      'valide'   => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
    ));

    $this->widgetSchema->setNameFormat('ligne_gare_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'LigneGare';
  }

  public function getFields()
  {
    return array(
      'ligne_id' => 'ForeignKey',
      'gare_id'  => 'ForeignKey',
      'valide'   => 'Boolean',
    );
  }
}
