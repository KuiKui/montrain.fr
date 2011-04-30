<?php

/**
 * Discussion filter form base class.
 *
 * @package    montrain.fr
 * @subpackage filter
 * @author     KuiKui
 */
abstract class BaseDiscussionFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'ligne_id'       => new sfWidgetFormPropelChoice(array('model' => 'Ligne', 'add_empty' => true)),
      'nom'            => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'nombre_message' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'importante'     => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'valide'         => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'created_at'     => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'updated_at'     => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
    ));

    $this->setValidators(array(
      'ligne_id'       => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Ligne', 'column' => 'id')),
      'nom'            => new sfValidatorPass(array('required' => false)),
      'nombre_message' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'importante'     => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'valide'         => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'created_at'     => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'     => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('discussion_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Discussion';
  }

  public function getFields()
  {
    return array(
      'id'             => 'Number',
      'ligne_id'       => 'ForeignKey',
      'nom'            => 'Text',
      'nombre_message' => 'Number',
      'importante'     => 'Boolean',
      'valide'         => 'Boolean',
      'created_at'     => 'Date',
      'updated_at'     => 'Date',
    );
  }
}
