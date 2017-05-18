Ext.define('User.view.UserGroupGrid', 
	{
	extend: 'Admin.view.ux.GridPanel',
	alias: 'widget.User.view.UserGroupGrid',
	itemId: "UserGroupGrid",
	
		requires:
		[
		"User.view.field.UserGroupNameGroupText"
		],
	
	name: "User",
	store: "UserGroup",
	
		dockedItems:
		[
			{
			xtype: 'pagingtoolbar',
			store: 'UserGroup',
			dock: 'bottom',
			displayInfo: true
			}
		],
	
		columns:
		[
			{
			header: 'ID',
			dataIndex: 'idUserGroup',
			filter: 'number',
			width: "5%"
			},
			{
			header: 'Название группы',
			dataIndex: 'nameGroup',
			filter: 'string',
			width: "50%",
				editor:
				{
				xtype: "User.view.field.UserGroupNameGroupText",
				hideLabel: true
				}
			},
			{
			header: 'Роли группы',
			dataIndex: 'roles',
			width: "30%",
                renderer: function(val, x, rec)
                {
                    if(rec.get("roles"))
                    {
                    var value = "",
                        roles = rec.get("roles");

                        for(var i = 0; i < roles.length; i++)
                        {
                            if(value != "") value += ", ";

                        value += roles[i]["userrole"]["nameRole"];
                        }

                    return value;
                    }
                    else return "";
                }
			},
			{
			header: 'Статус',
			dataIndex: 'userGroup.status',
			filter: 'boolean',
			width: "15%",
				editor:
				{
				xtype: "comboBoxStatus",
				hideLabel: true
				}
			}
		],
		listeners: 
		{
			beforeEditUpdate: function(editor, context)
			{			
				if(context.field == "userGroup.status")
				{
				context.grid.mask("Загрузка...");
				
				context.record.set("status", context.value);
					
					context.record.save
					(
						{
							success: function(model, operation)
							{
							context.record.commit();
							context.grid.unmask();
							},
							failure: function(model, operation)
							{
							context.record.reject();
							context.grid.unmask();
							
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
				
				return false;
				}
				else return true;	
			}
		},
		initComponent: function()
		{
			this.buttonCreate = 
			{
			text: "Добавить",
			hidden: Admin.getApplication().Access.is("User", "isCreate") == true ? false : true
			};
			
			this.buttonUpdate = 
			{
			text: "Изменить",
			hidden: Admin.getApplication().Access.is("User", "isUpdate") == true ? false : true
			};
			
			this.buttonDestroy = 
			{
			text: "Удалить",
			hidden: Admin.getApplication().Access.is("User", "isDestroy") == true ? false : true
			}
		
		this.callParent();
		}
	}
);