/*+***********************************************************************************************************************************
 * The contents of this file are subject to the YetiForce Public License Version 1.1 (the "License"); you may not use this file except
 * in compliance with the License.
 * Software distributed under the License is distributed on an "AS IS" basis, WITHOUT WARRANTY OF ANY KIND, either express or implied.
 * See the License for the specific language governing rights and limitations under the License.
 * The Original Code is YetiForce.
 * The Initial Developer of the Original Code is YetiForce. Portions created by YetiForce are Copyright (C) www.yetiforce.com. 
 * All Rights Reserved.
 *************************************************************************************************************************************/
jQuery.Class('Settings_Mail_Config_Js', {}, {
	registerChangeConfig : function() {
		var thisInstance = this;
		var container = jQuery('.configContainer');
		container.on('change', '.configCheckbox', function() {
			var name = jQuery(this).attr('name');
			var val = this.checked;
			var progressIndicator = jQuery.progressIndicator();
			var params = {};
			params['module'] = app.getModuleName();
			params['parent'] = app.getParentModuleName();
			params['action'] = 'SaveAjax';
			params['mode'] = 'updateConfig';
			params['type'] = 'mailIcon';
			params['name'] = name;
			params['val'] = val;
			
			AppConnector.request(params).then(
				function(data) {
					progressIndicator.progressIndicator({'mode' : 'hide'});
					var params = {};
					params['text'] = data.result.message;
					Settings_Vtiger_Index_Js.showMessage(params);
				},
				function(error) {
					progressIndicator.progressIndicator({'mode' : 'hide'});
				}
			);
		});
	},
	registerEvents : function() {
		var thisInstance = this;
		thisInstance.registerChangeConfig();
	},
});