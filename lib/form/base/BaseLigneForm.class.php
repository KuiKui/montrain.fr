<?php

/**
 * Ligne form base class.
 *
 * @method Ligne getObject() Returns the current form's model object
 *
 * @package    montrain.fr
 * @subpackage form
 * @author     KuiKui
 */
abstract class BaseLigneForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'              => new sfWidgetFormInputHidden(),
      'nom'             => new sfWidgetFormInputText(),
      'valide'          => new sfWidgetFormInputCheckbox(),
      'ligne_gare_list' => new sfWidgetFormPropelChoice(array('multiple' => true, 'model' => 'Gare')),
    ));

    $this->setValidators(array(
      'id'              => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'nom'             => new sfValidatorString(array('max_length' => 255)),
      'valide'          => new sfValidatorBoolean(),
      'ligne_gare_list' => new sfValidatorPropelChoice(array('multiple' => true, 'model' => 'Gare', 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorPropelUnique(array('model' => 'Ligne', 'column' => array('nom')))
    );

    $this->widgetSchema->setNameFormat('ligne[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Ligne';
  }


  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['ligne_gare_list']))
    {
      $values = array();
      foreach ($this->object->getLigneGares() as $obj)
      {
        $values[] = $obj->getGareId();
      }

      $this->setDefault('ligne_gare_list', $values);
    }

  }

  protected function doSave($con = null)
  {
    parent::doSave($con);

    $this->saveLigneGareList($con);
  }

  public function saveLigneGareList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['ligne_gare_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $c = new Criteria();
    $c->add(LigneGarePeer::LIGNE_ID, $this->object->getPrimaryKey());
    LigneGarePeer::doDelete($c, $con);

    $values = $this->getValue('ligne_gare_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new LigneGare();
        $obj->setLigneId($this->object->getPrimaryKey());
        $obj->setGareId($value);
        $obj->save();
      }
    }
  }

}
