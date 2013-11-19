var floorEditor=floorEditor||{};

floorEditor.scale=1;

floorEditor.FloorLayer=function(floor){
	this.data=floor;
	var that=this;

	this.canvas=$('<canvas class="floor"></canvas>');
	this.sandbox=$('<div class="floorsandbox"></div>').append(this.canvas);

	this.tables=[];
	this.decoration=[];

	$(this.data.tables).each(function(i,e){
		that.addTable(new floorEditor.Table(e));
	});

	$(this.data.floorObjects).each(function(i,e){
		that.addDecoration(new floorEditor.Decoration(e));
	});

	//this.refresh();
	this.viewport=$('#viewport');

	var scrollTop,scrollLeft,clickSuspend=false;
	this.canvas
	.bind('dragstart',function(ev,dd){
		scrollTop=that.viewport.scrollTop();
		scrollLeft=that.viewport.scrollLeft();
		clickSuspend=true;
	})
	.bind('drag',function(ev,dd){
		that.viewport.scrollTop(scrollTop-dd.deltaY).scrollLeft(scrollLeft-dd.deltaX);
	})
	.bind('dragend',function(){
		window.setTimeout(function(){clickSuspend=false;},60);
	})
	.click(function(){
		if(clickSuspend===false){
			openFloorDialog(that.data);
		}
	});
}
floorEditor.FloorLayer.prototype={
	save:function(now){
		var that=this;

		var _invokeFunction=function(){
			rpc({
				method:'setFloor',
				prefix:'manager',
				params:[that.data],
				success:function(){

				}
			});
		};

		if(now!==true){
			this.saveWaitingTime=3;
			if(this.saveThreadId==null){
				this.saveThreadId=window.setInterval(function(){
					if((--that.saveWaitingTime)<=0){
						_invokeFunction();
						window.clearInterval(that.saveThreadId);
						that.saveThreadId=null;
						that.saveWaitingTime=0;
					}
				},1000);
			}
		}else{
			_invokeFunction();
		}
	},
	refresh:function(){
		this.canvas.attr('width',this.data.width*floorEditor.scale).attr('height',this.data.height*floorEditor.scale);

		var g=this.canvas[0].getContext('2d');
		g.setTransform(1*floorEditor.scale,0,0,1*floorEditor.scale,0,0);
		UI.loadImage(function(image){
			g.drawImage(image,0,0);
		},(this.data.imageLocation||''));

		this.sandbox.css({width:(this.data.width*floorEditor.scale)+'px',height:(this.data.height*floorEditor.scale)+'px'});

		var elementRefresh=function(i,e){
			e.refresh();
			e.element.css({left:e.data.x*floorEditor.scale,top:e.data.y*floorEditor.scale});
		}
		$(this.tables).each(elementRefresh);
		$(this.decoration).each(elementRefresh);
	},
	addTable:function(table){
		this.tables.push(table);
		table.setFloor(this);
		this.sandbox.append(table.element);
	},
	addDecoration:function(deco){
		this.decoration.push(deco);
		deco.setFloor(this);
		this.sandbox.append(deco.element);
	},
	setBackgroundImage:function(src){
		this.data.imageLocation=src;
		this.refresh();
		this.save();
	}
};

floorEditor.Table=function(table){
	this.init(table);
};
floorEditor.Table.prototype={
	CHAIR_SIZE:{width:47,height:40},
	init:function(data){
		var that=this;
		this.data=data;

		var clickSuspend=false;
		this.element=$('<div class="table"><div class="object-background"></div><canvas></canvas><div class="text">'+(this.data.name||'')+'</div></div>')
			.click(function(event){
				if(clickSuspend===false){
					that.openDialog();
				}
			})
			.bind('dragstart',function(){
				clickSuspend=true;
			})
			.bind('drag',function(ev,dd){
				var el=$(ev.currentTarget);
				var floorOffset=el.parent().offset();
				var newLeft=Math.min(Math.max(dd.offsetX-floorOffset.left,0),that.floor.sandbox.width()-that.element.width());
				var newTop=Math.min(Math.max(dd.offsetY-floorOffset.top,0),that.floor.sandbox.height()-that.element.height());
				el.css({left:newLeft,top:newTop});

				that.data.x=Math.round(newLeft/floorEditor.scale);
				that.data.y=Math.round(newTop/floorEditor.scale);

				that.floor.save();
			})
			.bind('dragend',function(){
				
				window.setTimeout(function(){
					clickSuspend=false;
				},60);
			});
		this.canvas=this.element.children('canvas');
		this.text=this.element.children('.text');
		//this.refresh();
	},
	setFloor:function(floor){
		this.floor=floor;
	},
	save:function(){
		rpc({
			method:'setTable',
			prefix:'manager',
			params:[this.data],
			success:function(){
			}
		});
	},
	refresh:function(){
		var that=this;
		var totalHeight=typeof(this.data.height)==='number'?this.data.height:parseInt(this.data.height);
		if(this.data.numberOfClients>0){
			totalHeight+=Math.floor(this.CHAIR_SIZE.height/3*4);
		}

		this.canvas.attr('width',this.data.width*floorEditor.scale).attr('height',totalHeight*floorEditor.scale);
		this.element.css({
			width:(this.data.width*floorEditor.scale)+'px',
			height:(totalHeight*floorEditor.scale)+'px',
			zIndex:this.data.zindex,

			"-moz-transform":'rotate('+this.data.rotation+'deg)',
			"-webkit-transform":'rotate('+this.data.rotation+'deg)',
			"-o-transform":'rotate('+this.data.rotation+'deg)',
			"-ms-transform":'rotate('+this.data.rotation+'deg)',
			"transform":'rotate('+this.data.rotation+'deg)'

		});
		this.text.text(that.data.name).css({top: (this.element.height()-this.text.height())/2, fontSize:floorEditor.scale+'em' });

		var g=this.canvas[0].getContext('2d');
		g.setTransform(1*floorEditor.scale,0,0,1*floorEditor.scale,0,0);
		UI.loadImage(function(floorImage,chair){
			var chairSize=that.CHAIR_SIZE;
			var numPerSide=Math.ceil(that.data.numberOfClients/2);
			var space=that.data.width/numPerSide;
			var offset=Math.ceil((space-chairSize.width)/2);

			space=space*floorEditor.scale;
			var factor=1;
			for(var i=0;i<that.data.numberOfClients;i++){
				g.setTransform(1*floorEditor.scale,0,0,factor*floorEditor.scale,space*parseInt(i/2), (factor===1?0:totalHeight*floorEditor.scale) );
				g.drawImage(chair,offset,totalHeight-chairSize.height,chairSize.width,chairSize.height);
				factor*=-1;
			}

			var tableTop=Math.ceil((totalHeight-that.data.height)/2*floorEditor.scale);
			g.setTransform(1*floorEditor.scale,0,0,1*floorEditor.scale,0,tableTop);
			g.drawImage(floorImage,0,0,that.data.width,that.data.height);
		},this.data.imageLocation,this.data.chairImageLocation);

	},
	getDialogHtml:function(){
		var isNewTable=this.data.oid==='-1';
		return [
			'<div class="dialog tableDialog">',
			'<div class="titlebar" i18n="i18n">'+(isNewTable?'Add Table':'Edit Table')+'</div>',
			'<div class="dialogbody">',
			'<div class="message">',
			'<div class="fv"><span class="f" i18n="i18n">Name</span><input type="text" class="v" name="name" /></div>',
			'<div class="fv"><span class="f" i18n="i18n">Description</span><input type="text" class="v" name="description" /></div>',
			'<div class="fv"><span class="f" i18n="i18n">Type</span><select class="v" name="type"><option value="restaurant" i18n="i18n">restaurant</option><option ' +(this.data.type=='takeaway'?'selected="true"':'')+ ' value="takeaway" i18n="i18n">takeaway</option><option ' +(this.data.type=='delivery'?'selected="true"':'')+ ' value="delivery" i18n="i18n">delivery</option><option ' +(this.data.type=='bar'?'selected="true"':'')+ ' value="bar" i18n="i18n">bar</option></select></div>',
			//'<input type="text" class="v" name="type" /></div>',
			'<div class="fv"><span class="f" i18n="i18n">Width</span><input type="text" class="v" name="width" datatype="integer" /></div>',
			'<div class="fv"><span class="f" i18n="i18n">Height</span><input type="text" class="v" name="height" datatype="integer" /></div>',
			'<div class="fv"><span class="f" i18n="i18n">Rotation</span><input type="text" class="v" name="rotation" datatype="integer" /></div>',
			'<div class="fv"><span class="f" i18n="i18n">ZIndex</span><input type="text" class="v" name="zindex" datatype="integer" /></div>',
			'<div class="fv"><span class="f" i18n="i18n">Table Order</span><input type="text" class="v" name="tableOrder" datatype="integer" /></div>',
			'<div class="fv"><span class="f" i18n="i18n">Chair Image</span><a href="javascript:void(0)" class="lnkImageUploader">Attach an image</a><input type="hidden" name="chairImageLocation" /></div>',
			'<div class="fv"><span class="f" i18n="i18n">Chair Number</span><input type="text" class="v" name="numberOfClients" /></div>',
			'</div>',
			'<div class="buttonbar"><div class="cssbutton" value="delete" style="display:none;" i18n="i18n">Delete</div><div class="cssbutton" value="copy" style="display:none;" i18n="i18n">Copy</div><div class="cssbutton" value="cancel" i18n="i18n">Cancel</div><div class="cssbutton" value="ok" i18n="i18n">OK</div><div class="clearboth"></div></div>',
			'</div>',
			'</div>'
		].join('');
	},
	openDialog:function(){
		var that=this;
		var isNewTable=this.data.oid==='-1';

		that.element.addClass('selected');

		$('body').popupWindow({
			html:this.getDialogHtml(),
			dismissOnBlur:false,
			beforeshow:function(){
				var thisDialog=this;

				var dismissDialog=function(){
					thisDialog.animate({opacity:0},200,function(){
						thisDialog.remove();
						window.setTimeout(function(){that.element.removeClass('selected');},200);
					});
				};

				$('.cssbutton[value=delete]',thisDialog).click(function(){
					if(that.data.status!=='free'){
						Dialog.show({
							title:localizeText('Error'),
							message:localizeText('Can not delete the table, which is not free!'),
							buttons:['OK']
						});
					}else{
						rpc({
							method:'deleteTable',
							prefix:'manager',
							params:[that.data.oid],
							applyElement:$('.dialog',thisDialog),
							success:function(){
								that.element.remove();
								that.floor.data.tables=$(that.floor.data.tables).map(function(i,e){
									if(e===that.data){
										return null;
									}
									return e;
								}).get();
	
								dismissDialog();
							}
						});
					}
				}).css({display:isNewTable?'none':'block'});


				$('.cssbutton[value=copy]').bind(bindEvent,function(){
					var copydata={},copykey;

					for(copykey in that.data){
						if(that.data.hasOwnProperty(copykey)){
							copydata[copykey]=that.data[copykey];
						}
					}
					copydata.oid="-1";

					DataBinding.datalize(thisDialog,copydata);

					rpc({
						method:'addTable',
						prefix:'manager',
						params:[copydata],
						applyElement:$('.dialog',thisDialog),
						success:function(oid){
							var newTable;
							if(oid!==undefined){
								copydata.oid=oid;
								newTable=new floorEditor.Table(copydata);
								that.floor.addTable(newTable);
								newTable.refresh();
								that.floor.data.tables.push(copydata);
								that.floor.refresh();
							}

							dismissDialog();
						}
					});
				}).css({display:isNewTable?'none':'block'});


				$('.cssbutton[value=cancel]',thisDialog).click(function(){
					dismissDialog();
				});

				$('.cssbutton[value=ok]',thisDialog).click(function(){
					DataBinding.datalize(thisDialog,that.data);
					rpc({
						method:isNewTable?'addTable':'setTable',
						prefix:'manager',
						params:[that.data],
						applyElement:$('.dialog',thisDialog),
						success:function(oid){
							if(isNewTable&&oid!==undefined){
								that.data.oid=oid;
								that.floor.addTable(that);
								that.floor.data.tables.push(that.data);
							}
							that.refresh();

							dismissDialog();
						}
					});
				});

				DataBinding.visualize(thisDialog,that.data);
				var lnkImage=$('.lnkImageUploader',this).bind(bindEvent,function(event){
					UI.showImageUploader($('.dialog .dialogbody',thisDialog),'chairs',function(src){
						$(event.currentTarget).empty().append('<img class="imagepreview" alt="'+localizeText('No Preview')+'" src="'+src+'"/>').parent().children('input').val(src);
					},$(event.currentTarget).parent().children('input').val());
				});

				var src=lnkImage.parent().children('input').val();
				if(src!==''){
					lnkImage.empty().append('<img class="imagepreview" alt="'+localizeText('No Preview')+'" src="'+src+'"/>');
				}
			}
		});
	}
};

floorEditor.Car=function(data){
	this.init(data);
};
floorEditor.Car.prototype=$.extend({},floorEditor.Table.prototype,{
	getDialogHtml:function(){
		var isNewTable=this.data.oid==='-1';
		return [
			'<div class="dialog">',
			'<div class="titlebar" i18n="i18n">'+(isNewTable?'Add Table':'Edit Table')+'</div>',
			'<div class="dialogbody">',
			'<div class="message">',
			'<div class="fv"><span class="f" i18n="i18n">Name</span><input type="text" class="v" name="name" /></div>',
			'<div class="fv"><span class="f" i18n="i18n">Description</span><input type="text" class="v" name="description" /></div>',
			'<div class="fv"><span class="f" i18n="i18n">Width</span><input type="text" class="v" name="width" datatype="integer" /></div>',
			'<div class="fv"><span class="f" i18n="i18n">Height</span><input type="text" class="v" name="height" datatype="integer" /></div>',
			'<div class="fv"><span class="f" i18n="i18n">ZIndex</span><input type="text" class="v" name="zindex" datatype="integer" /></div>',
			'<div class="fv"><span class="f" i18n="i18n">Table Order</span><input type="text" class="v" name="tableOrder" datatype="integer" /></div>',
			'</div>',
			'<div class="buttonbar"><div class="cssbutton" value="delete" style="display:none;" i18n="i18n">Delete</div><div class="cssbutton" value="cancel" i18n="i18n">Cancel</div><div class="cssbutton" value="ok" i18n="i18n">OK</div><div class="clearboth"></div></div>',
			'</div>',
			'</div>'
		].join('');
	},
});


floorEditor.Decoration=function(data){
	this.init(data);
};
floorEditor.Decoration.prototype={
	init:function(data){
		var that=this;
		this.data=data;

		var clickSuspend=false;
		this.element=$('<div class="decoration"><div class="object-background"></div><canvas></canvas><div class="text">'+(this.data.name||'')+'</div></div>')
			.click(function(event){
				if(clickSuspend===false){
					that.openDialog();
				}
			})
			.bind('dragstart',function(){
				clickSuspend=true;
			})
			.bind('drag',function(ev,dd){
				var el=$(ev.currentTarget);
				var floorOffset=el.parent().offset();
				var newLeft=Math.min(Math.max(dd.offsetX-floorOffset.left,0),that.floor.sandbox.width()-that.element.width());
				var newTop=Math.min(Math.max(dd.offsetY-floorOffset.top,0),that.floor.sandbox.height()-that.element.height());
				el.css({left:newLeft,top:newTop});

				that.data.x=Math.round(newLeft/floorEditor.scale);
				that.data.y=Math.round(newTop/floorEditor.scale);

				that.floor.save();
			})
			.bind('dragend',function(){
				that.floor.save();
				window.setTimeout(function(){
					clickSuspend=false;
				},60);
			});

		this.canvas=this.element.children('canvas');
		this.text=this.element.children('.text');
	},
	setFloor:function(floor){
		this.floor=floor;
	},
	refresh:function(){
		var that=this;
		var totalHeight=typeof(this.data.height)==='number'?this.data.height:parseInt(this.data.height);
		this.canvas.attr('width',this.data.width*floorEditor.scale).attr('height',totalHeight*floorEditor.scale);
		this.element.css({
			width:(this.data.width*floorEditor.scale)+'px',
			height:(totalHeight*floorEditor.scale)+'px',
			zIndex:this.data.zindex
		});
		this.text.text(that.data.name).css({top: (this.element.height()-this.text.height())/2, fontSize:floorEditor.scale+'em' });

		var g=this.canvas[0].getContext('2d');
		g.setTransform(1*floorEditor.scale,0,0,1*floorEditor.scale,0,0);
		UI.loadImage(function(image){
			var tableTop=Math.ceil((totalHeight-that.data.height)/2*floorEditor.scale);
			g.setTransform(1*floorEditor.scale,0,0,1*floorEditor.scale,0,tableTop);
			g.drawImage(image,0,0,that.data.width,that.data.height);
		},this.data.imageLocation);

	},
	getDialogHtml:function(){
		var isNewDeco=this.data.oid===-1;
		return [
			'<div class="dialog">',
			'<div class="titlebar" i18n="i18n">'+(isNewDeco?'Add Decoration':'Edit Decoration')+'</div>',
			'<div class="dialogbody">',
			'<div class="message">',
			'<div class="fv"><span class="f" i18n="i18n">Name</span><input type="text" class="v" name="name" /></div>',
			'<div class="fv"><span class="f" i18n="i18n">Description</span><input type="text" class="v" name="description" /></div>',
			'<div class="fv"><span class="f" i18n="i18n">Width</span><input type="text" class="v" name="width" datatype="integer" /></div>',
			'<div class="fv"><span class="f" i18n="i18n">Height</span><input type="text" class="v" name="height" datatype="integer" /></div>',
			'</div>',
			'<div class="buttonbar"><div class="cssbutton" value="delete" style="display:none;" i18n="i18n">Delete</div><div class="cssbutton" value="cancel" i18n="i18n">Cancel</div><div class="cssbutton" value="ok" i18n="i18n">OK</div><div class="clearboth"></div></div>',
			'</div>',
			'</div>'
		].join('');
	},
	openDialog:function(){
		var that=this;
		var isNewDeco=this.data.oid===-1;
		that.element.addClass('selected');
		$('body').popupWindow({
			html:this.getDialogHtml(),
			dismissOnBlur:false,
			beforeshow:function(){
				var thisDialog=this;

				var dismissDialog=function(){
					thisDialog.animate({opacity:0},200,function(){
						thisDialog.remove();
						window.setTimeout(function(){that.element.removeClass('selected');},200);
					});
				};

				$('.cssbutton[value=delete]',thisDialog).bind(bindEvent,function(){
					that.floor.decoration=$(that.floor.decoration).map(function(i,e){
						if(that.data == e.data){
							return null;
						}else{
							return e;
						}
					//	return that.data===e?null:e;
					}).get();
					
					var fobject = new Array();
					for(var i = 0; i < that.floor.decoration.length; i++){
						fobject[i] = that.floor.decoration[i].data;
					}
					that.floor.data.floorObjects=fobject;
					
					that.floor.save();
					that.element.remove();
					dismissDialog();
				}).css({display:isNewDeco?'none':'block'});

				$('.cssbutton[value=cancel]',thisDialog).click(function(){
					dismissDialog();
				});

				$('.cssbutton[value=ok]',thisDialog).click(function(){
					DataBinding.datalize(thisDialog,that.data);

					if(isNewDeco){
						that.floor.data.floorObjects.push(that.data);
						that.floor.addDecoration(that);
					}

					that.floor.save();
					that.refresh();
					dismissDialog();
				});

				DataBinding.visualize(thisDialog,that.data);
			}
		});
	}
};