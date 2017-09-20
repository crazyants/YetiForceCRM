<?php

/**
 * Verify user data cction class
 * @package YetiForce.Action
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 2.0 (licenses/License.html or yetiforce.com)
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */
class Users_VerifyData_Action extends Vtiger_Action_Controller
{

	/**
	 * Function to check permission
	 * @param \App\Request $request
	 * @throws \App\Exceptions\NoPermitted
	 */
	public function checkPermission(\App\Request $request)
	{
		$currentUser = Users_Record_Model::getCurrentUserModel();
		if (!$currentUser->isAdminUser() && $currentUser->getId() != $request->get('record')) {
			throw new \App\Exceptions\NoPermitted('LBL_PERMISSION_DENIED');
		}
	}

	/**
	 * Process
	 * @param \App\Request $request
	 */
	public function process(\App\Request $request)
	{
		$message = '';
		$moduleName = $request->getModule();
		$checkUserName = false;
		if (Users_Module_Model::checkMailExist($request->get('email'), (int) $request->get('record'))) {
			$message = \App\Language::translate('LBL_USER_MAIL_EXIST', $moduleName);
		}
		if ($request->isEmpty('record', true)) {
			$checkUserName = true;
			if (!$request->isEmpty('password', true)) {
				$checkPassword = Settings_Password_Record_Model::checkPassword($request->get('password'));
				if ($checkPassword) {
					$message = $checkPassword;
				}
			}
		} else {
			$recordModel = Vtiger_Record_Model::getInstanceById($request->getInteger('record'), $moduleName);
			if ($request->get('userName') !== $recordModel->get('user_name')) {
				$checkUserName = true;
			}
		}
		if ($checkUserName) {
			if ($checkUserName = Users_Module_Model::checkUserName($request->get('userName'), (int) $request->get('record'))) {
				$message = $checkUserName;
			}
		}
		$response = new Vtiger_Response();
		$response->setResult(['message' => $message]);
		$response->emit();
	}
}
