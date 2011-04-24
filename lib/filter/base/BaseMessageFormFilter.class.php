<?php

/**
 * Message filter form base class.
 *
 * @package    montrain
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseMessageFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'discussion_id' => new sfWidgetFormPropelChoice(array('model' => 'Discussion', 'add_empty' => true)),
      'contenu'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'valide'        => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'created_at'    => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'updated_at'    => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
    ));

    $this->setValidators(array(
      'discussion_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Discussion', 'column' => 'id')),
      'contenu'       => new sfValidatorPass(array('required' => false)),
      'valide'        => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'created_at'    => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'    => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('message_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Message';
  }

  public function getFields()
  {
    return array(
      'id'            => 'Number',
      'discussion_id' => 'ForeignKey',
      'contenu'       => 'Text',
      'valide'        => 'Boolean',
      'created_at'    => 'Date',
      'updated_at'    => 'Date',
    );
  }
}
