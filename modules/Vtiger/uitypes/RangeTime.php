<?php

/**
 * UIType RangeTime Field Class
 * @package YetiForce.Fields
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author Radosław Skrzypczak <r.skrzypczak@yetiforce.com>
 */
class Vtiger_RangeTime_UIType extends Vtiger_Base_UIType
{

	/**
	 * {@inheritDoc}
	 */
	public function getDisplayValue($value, $record = false, $recordInstance = false, $rawText = false)
	{
		$result = vtlib\Functions::getRangeTime($value, !is_null($value));
		$mode = $this->get('field')->getFieldParams();
		if (empty($mode)) {
			$mode = 'short';
		}
		return \App\Purifier::encodeHtml($result[$mode]);
	}

	public function isActiveSearchView()
	{
		return false;
	}
}
