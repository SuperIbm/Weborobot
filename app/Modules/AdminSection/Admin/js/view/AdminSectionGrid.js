Ext.define('AdminSection.view.AdminSectionGrid', 
	{
    extend: 'Admin.view.ux.GridPanel',
	alias: 'widget.AdminSection.view.AdminSectionGrid',
	
		requires:
		[
		"AdminSection.view.field.AdminSectionMenuLeftComboBox",
		"AdminSection.view.field.AdminSectionIconSmallText",
		"AdminSection.view.field.AdminSectionIconBigText",
		"AdminSection.view.field.AdminSectionPathToJsText",
		"AdminSection.view.field.AdminSectionPathToCssText"
		],
		
	name: "AdminSection",
	
		store:
		{
		type: 'AdminSection.store.AdminSection'
		},
	
		viewConfig:
		{
			plugins:
			{
			ptype: 'gridviewdragdrop',
			ddGroup: "AdminSection.view.AdminSectionGrid"
			}
		},
	
		columns:
		[
			{
			header: 'ID',
			dataIndex: 'idAdminSection',
			width: "5%",
			filter: 'number'
			},
			{
			header: 'Название раздела',
			dataIndex: 'labelSection',
			width: "65%",
			filter: false,
			sortable: false
			},
			{
			header: 'Левое меню',
			dataIndex: 'menuLeft',
			width: "15%",
			filter: false,
			sortable: false,
				editor:
				{
				xtype: "AdminSection.view.field.AdminSectionMenuLeftComboBox",
				hideLabel: true	
				}
			},
			{
			header: 'Пакет',
			dataIndex: 'bundle',
			hidden: true,
			sortable: false
			},
			{
			header: 'Иконка маленькая',
			dataIndex: 'iconSmall',
			hidden: true,
			sortable: false,
				editor:
				{
				xtype: "AdminSection.view.field.AdminSectionIconSmallText",
				hideLabel: true	
				}
			},
			{
			header: 'Иконка большая',
			dataIndex: 'iconBig',
			hidden: true,
			sortable: false,
				editor:
				{
				xtype: "AdminSection.view.field.AdminSectionIconBigText",
				hideLabel: true	
				}
			},
			{
			header: 'Путь к JavaScript',
			dataIndex: 'iconBig',
			hidden: true,
			sortable: false,
				editor:
				{
				xtype: "AdminSection.view.field.AdminSectionPathToJsText",
				hideLabel: true	
				}
			},
			{
			header: 'Путь к CSS',
			dataIndex: 'iconBig',
			hidden: true,
			sortable: false,
				editor:
				{
				xtype: "AdminSection.view.field.AdminSectionPathToCssText",
				hideLabel: true	
				}
			},
			{
			header: 'Статус',
			dataIndex: 'status',
			width: "15%",
			filter: false,
			sortable: false,
				editor:
				{
				xtype: 'comboBoxStatus',
				hideLabel: true
				}
			}
		],
		initComponent: function()
		{
			this.buttonUpdate = 
			{
			text: "Изменить",
			hidden: !Admin.getApplication().Access.is("AdminSection", "isUpdate")
			};
		
		this.callParent();
		var thisObj = this;
		
		this.getStore().getProxy().setExtraParam("bundleShow", this.bundleShow);
		this.getStore().load();
		
			this.getView().on("beforedrop", 
				function(node, dragData, overModel, dropPosition, eOpts)
				{
					if(overModel.store.isFiltered() == true)
					{
						Ext.Msg.show
						(
							{
							title: "Предупреждение!",
							msg: "Для возможности изменения позиции элементов вам нужно снять фильтр!",
							icon: Ext.MessageBox.WARNING,
							buttons: Ext.MessageBox.OK
							}
						);
						
					return false;
					}
					else return true;
				}
			);
		
			this.getView().on("drop",
				function(node, dragData, overModel, dropPosition, eOpts)
				{
				thisObj.mask("Загрузка...");
				var index = overModel.store.indexOf(overModel);
				
					if(dropPosition == "after") index++;
					if(dropPosition == "before") index--;
				
					for(var i = 0; i < dragData.records.length; i++)
					{										
						Ext.Ajax.request
						(
							{
							url: '_api/AdminSection/AdminSectionAdminController/weight/',
							method: "POST",
								params:
								{
								weight: index,
								id: dragData.records[i].getData().idAdminSection
								},								
								success: function(response, options)
								{
                                thisObj.unmask();

								var jsonObj = Ext.util.JSON.decode(response.responseText);
								
									if(jsonObj["success"] == false)
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
                                thisObj.unmask();

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
			);
		}
	}
);