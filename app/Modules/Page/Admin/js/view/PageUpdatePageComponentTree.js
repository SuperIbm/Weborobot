Ext.define('Page.view.PageUpdatePageComponentTree',
	{
    extend: 'Admin.view.ux.TreePanel',
	alias: 'widget.Page.view.PageUpdatePageComponentTree',
	
	store: 'PageUpdatePageComponentTree',
	name: "PageUpdatePageComponentTree",
	
		selModel:
		{
		xtype: "treemodel", 
		mode: "MULTI"
		},
		
	selType: "rowmodel",
	
	canDeleteFirstNode: false,
	canEditFirstNode: false,
	
	region: 'west',
	split: true,
		root:
		{
		allowDrop: false,
		id: -1,
        expanded: true
		},

    rootVisible: false,
		
		margins: 
		{
		top: 5,
		right: 0,
		bottom: 5,
		left: 5
		},
		
	title: "Компоненты страницы",
	width: 414,
	
		viewConfig:
		{
			plugins:
			{
			ptype: 'treeviewdragdrop',
			ddGroup: "Page.view.PageUpdatePageComponentTree"
			}
		},
		
		tools:
		[
			{
			type: 'refresh',
			tooltip: 'Обновить дерево',
			itemId: 'refresh'
			}
		],
	
		initComponent: function()
		{			
			this.buttonUpdate = 
			{
			text: "Изменить",
			hidden: !Admin.getApplication().Access.is("Page", "isUpdate")
			};
			
			this.buttonDestroy = 
			{
			text: "Удалить",
			hidden: !Admin.getApplication().Access.is("Page", "isDestroy")
			};
			
		this.callParent();			
			
			this.getView().on("beforedrop",
				function(node, dragData, overModel, dropPosition, dropHandlers, eOpts)
				{							
					if(nodeDropCurrent.getOwnerTree().name == "PageUpdateModuleAndComponentTree")
					{
						var nodeNew = 
						{
						text: nodeDropCurrent.parentNode.getData().text + ": " + nodeDropCurrent.getData().text,
						leaf: true,
						icon: "engine/app/Modules/Page/admin/images/icon_PageComponent_small.png",
						allowDrop: true,
						nameModule: nodeDropCurrent.getData().nameModule,
						nameBundle: nodeDropCurrent.getData().nameBundle,
                        nameComponent: nodeDropCurrent.getData().nameComponent,
						idComponent: nodeDropCurrent.getData().idComponent
						};
								
						if(targetNodeCurrent.getData().allowDrop == true && dropPosition == "append")
						{
						nodeNew = targetNodeCurrent.appendChild(nodeNew);
							
							Ext.Ajax.request
							(
								{
								url: '_api/PageComponent/PageComponentAdminController/create/',
								method: "POST",
									params:
									{
									idComponent: nodeDropCurrent.getData().idComponent,
									idPage: targetNodeCurrent.getData().idPage,
									numberBlock: targetNodeCurrent.parentNode.indexOf(targetNodeCurrent) + 1,
									weight: targetNodeCurrent.indexOf(nodeNew)							
									},								
									success: function(response, options)
									{
									var result = Ext.util.JSON.decode(response.responseText);
									
										if(result["success"] == true)
										{
										nodeNew.setId(result["data"]["idPageComponent"]);
										nodeNew.set("id", result["data"]["idPageComponent"]);
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
										
										nodeNew.remove();
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
										
									nodeNew.remove();
									}
								}
							);
						}
						else if((dropPosition == "before" || dropPosition == "after") && targetNodeCurrent.parentNode.isRoot() == false)
						{
							if(dropPosition == "before") nodeNew = targetNodeCurrent.parentNode.insertBefore(nodeNew, targetNodeCurrent);
							else if(dropPosition == "after") nodeNew = targetNodeCurrent.parentNode.insertBefore(nodeNew, targetNodeCurrent.nextSibling);
							
							Ext.Ajax.request
							(
								{
								url: '_api/PageComponent/PageComponentAdminController/create/',
								method: "POST",
									params:
									{
									idComponent: nodeDropCurrent.getData().idComponentAction,
									idPage: targetNodeCurrent.parentNode.getData().idPage,
									numberBlock: targetNodeCurrent.parentNode.parentNode.indexOf(targetNodeCurrent.parentNode) + 1,
									weight: targetNodeCurrent.parentNode.indexOf(nodeNew)							
									},								
									success: function(response, options)
									{
									var result = Ext.util.JSON.decode(response.responseText);
									
										if(result["success"] == true)
                                        {
                                            nodeNew.setId(result["data"]["idPageComponent"]);
                                            nodeNew.set("id", result["data"]["idPageComponent"]);
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
										
										nodeNew.remove();
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
										
									nodeNew.remove();
									}
								}
							);
						}
					
					return false;
					}
					else if(nodeDropCurrent.getOwnerTree().name == "PageUpdatePageComponentTree")
					{					
						if((dropPosition == "before" || dropPosition == "after") && targetNodeCurrent.parentNode.isRoot() == true) return false;
						else return true;
					}
					
				return false
				}
			);
			
			this.getView().on("drop",
				function(node, dragData, overModel, dropPosition, dropHandlers, eOpts)
				{
					if(nodeDropCurrent.getOwnerTree().name == "PageUpdatePageComponentTree")
					{
						if(targetNodeCurrent.getData().allowDrop == true && dropPosition == "append")
						{
							Ext.Ajax.request
							(
								{
								url: '_api/PageComponent/PageComponentAdminController/weight/',
								method: "POST",
									params:
									{
									weight: targetNodeCurrent.indexOf(nodeDropCurrent),
									idPageComponent: nodeDropCurrent.getData().id,
									idPage: nodeDropCurrent.parentNode.getData().idPage,
									numberBlock: targetNodeCurrent.parentNode.indexOf(targetNodeCurrent) + 1								
									},								
									success: function(response, options)
									{
									var result = Ext.util.JSON.decode(response.responseText);
									
										if(result["success"] == false)
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
						else if((dropPosition == "before" || dropPosition == "after") && targetNodeCurrent.parentNode.isRoot() == false)
						{
							Ext.Ajax.request
							(
								{
								url: '_api/PageComponent/PageComponentAdminController/weight/',
								method: "POST",
									params:
									{
									weight: targetNodeCurrent.parentNode.indexOf(nodeDropCurrent),
									idPageComponent: nodeDropCurrent.getData().id,
									idPage: targetNodeCurrent.parentNode.getData().idPage,
									numberBlock: targetNodeCurrent.parentNode.parentNode.indexOf(targetNodeCurrent.parentNode) + 1								
									},
									success: function(response, options)
									{
									var result = Ext.util.JSON.decode(response.responseText);
									
										if(result["success"] == false)
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
					}
				}
			);
		
			
		var targetNodeCurrent, nodeDropCurrent;
			
			this.getView().on("nodedragover",
				function(targetNode, position, dragData, e, eOpts)
				{
				targetNodeCurrent = targetNode;
				nodeDropCurrent = dragData.records[0];
				
					if((position == "before" || position == "after") && targetNodeCurrent.parentNode.isRoot() == true) return false;
					
				return true;
				}
			);
		}
	}
);