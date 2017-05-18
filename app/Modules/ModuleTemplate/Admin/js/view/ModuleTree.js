Ext.define('ModuleTemplate.view.ModuleTree',
	{
    extend: 'Admin.view.ux.TreePanel',
	alias: 'widget.ModuleTemplate.view.ModuleTree',
	
	name: "ModuleTree",
	store: "ModuleTree",
		
		viewConfig:
		{
			plugins:
			{
			ptype: 'treeviewdragdrop',
			ddGroup: "ModuleTemplate.view.ModuleTemplateGrid",
			enableDrag: false
			}
		},
		
		selModel:
		{
		xtype: "treemodel", 
		mode: "SINGLE"
		},
	
	canDeleteFirstNode: false,
	canUpdateFirstNode: false,
	
	filter: true,
	
	region: 'west',
	width: 280,
	title: "Модули",
	split: true,
	rootVisible: true,
	collapsible: true,
	margin: '5 0 5 5',
	
		initComponent: function()
		{
		this.callParent();
		var thisObj = this;	
			
			this.getView().on("beforedrop",
				function(node, dragData, overModel, dropPosition, dropHandlers, eOpts)
				{							
					for(var i = 0; i < nodeDropCurrent.length; i++)
					{
						Ext.Ajax.request
						(
							{
							url: '_api/ModuleTemplate/ModuleTemplateAdminController/update/',
							method: "POST",
								params:
								{
								idModule: targetNodeCurrent.getId(),
								idModuleTemplate: nodeDropCurrent[i].getData().idModuleTemplate
								},								
								success: function(response, options)
								{
								var jsonObj = Ext.util.JSON.decode(response.responseText);
								
									if(jsonObj["success"] == true)
									{
									thisObj.up("panel").down("grid").getStore("ModuleTemplate").load();
									}
									else if(jsonObj["errormsg"])
									{
                                        Ext.Msg.show
                                        (
                                            {
											title: "Ошибка!",
											msg: jsonObj["errormsg"],
											icon: Ext.MessageBox.ERROR,
											buttons: Ext.MessageBox.OK
                                            }
                                        );
									}
                                    else
                                    {
                                        Ext.Msg.show
                                        (
                                            {
											title: "Ошибка!",
											msg: "Произошла ошибка выполнения программы на сервере!",
											icon: Ext.MessageBox.ERROR,
											buttons: Ext.MessageBox.OK
                                            }
                                        );
                                    }
								},
								failure: function(response, options)
								{
									Ext.Msg.show
									(
										{
										title: "Ошибка!",
										msg: "Произошла ошибка выполнения программы на сервере!",
										icon: Ext.MessageBox.ERROR,
										buttons: Ext.MessageBox.OK
										}
									);
								}
							}
						);
					}
					
				return false;
				}
			);
			
		var targetNodeCurrent, nodeDropCurrent;
			
			this.getView().on("nodedragover",
				function(targetNode, position, dragData, e, eOpts)
				{
				targetNodeCurrent = targetNode;
				nodeDropCurrent = dragData.records;
				
					if((position == "before" || position == "after") && targetNodeCurrent.parentNode.isRoot() == true) return false;
					
				return true;
				}
			);
		},
		tools:
		[
			{
			type: 'refresh',
			tooltip: 'Обновить дерево',
			itemId: 'refresh'
			}
		]
	}
);