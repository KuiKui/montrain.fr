<?php

/**
 * Ligne filter form base class.
 *
 * @package    montrain.fr
 * @subpackage filter
 * @author     KuiKui
 */
abstract class BaseLigneFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'nom'             => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'valide'          => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'ligne_gare_list' => new sfWidgetFormPropelChoice(array('model' => 'Gare', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'nom'             => new sfValidatorPass(array('required' => false)),
      'valide'          => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'ligne_gare_list' => new sfValidatorPropelChoice(array('model' => 'Gare', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('ligne_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function addLigneGareListColumnCriteria(Criteria $criteria, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $criteria->addJoin(LigneGarePeer::LIGNE_ID, LignePeer::ID);

    $value = array_pop($values);
    $criterion = $criteria->getNewCriterion(LigneGarePeer::GARE_ID, $value);

    foreach ($values as $value)
    {
      $criterion->addOr($criteria->getNewCriterion(LigneGarePeer::GARE_ID, $value));
    }

    $criteria->add($criterion);
  }

  public function getModelName()
  {
    return 'Ligne';
  }

  public function getFields()
  {
    return array(
      'id'              => 'Number',
      'nom'             => 'Text',
      'valide'          => 'Boolean',
      'ligne_gare_list' => 'ManyKey',
    );
  }
}
