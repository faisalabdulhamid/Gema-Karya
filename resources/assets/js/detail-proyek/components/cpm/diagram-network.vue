<template>
	<div></div>
</template>

<script>
	require('gojs')

	var $ = go.GraphObject.make

	var blue = "#0288D1";
    var pink = "#B71C1C";
    var pinkfill = "#F8BBD0";
    var bluefill = "#B3E5FC";

	export default{
		name: "DiagramNetwork",
		template: '<div></div>',
		props: ['modelData'],
		data(){
			return { diagram: null }
		},
		mounted(){
			var self = this
			var myDiagram = $(go.Diagram, this.$el,{
				initialAutoScale: go.Diagram.Uniform,
				initialContentAlignment: go.Spot.Center,
				layout: $(go.LayeredDigraphLayout)
			})

		    myDiagram.nodeTemplate = 
		    	$(go.Node, "Auto",
			        $(go.Shape, "Rectangle",  // the border
			        	{ fill: "white", strokeWidth: 2 },
			          	new go.Binding("fill", "critical", function (b) { return (b ? pinkfill : bluefill ); }),
			          	new go.Binding("stroke", "critical", function (b) { return (b ? pink : blue); })),
		        	$(go.Panel, "Table",
		          		{ padding: 0.5 },
						$(go.RowColumnDefinition, { column: 1, separatorStroke: "black" }),
						$(go.RowColumnDefinition, { column: 2, separatorStroke: "black" }),
						$(go.RowColumnDefinition, { row: 1, separatorStroke: "black", background: "white", coversSeparators: true }),
						$(go.RowColumnDefinition, { row: 2, separatorStroke: "black" }),
						$(go.TextBlock, // earlyStart
		            		new go.Binding("text", "earlyStart"),
		            		{ row: 0, column: 0, margin: 5, textAlign: "center" }),
		          		$(go.TextBlock,
		            		new go.Binding("text", "length"),
		            		{ row: 0, column: 1, margin: 5, textAlign: "center" }),
		          		$(go.TextBlock,  // earlyFinish
		            		new go.Binding("text", "", function(d) { return (d.earlyStart + d.length).toFixed(2); }),
		            		{ row: 0, column: 2, margin: 5, textAlign: "center" }),

		          		$(go.TextBlock,
				            new go.Binding("text", "text"),
				            { row: 1, column: 0, columnSpan: 3, margin: 5,
				            textAlign: "center", font: "bold 14px sans-serif" }),

		          		$(go.TextBlock,  // lateStart
				            new go.Binding("text", "", function(d) { return (d.lateFinish - d.length).toFixed(2); }),
				            { row: 2, column: 0, margin: 5, textAlign: "center" }),
						$(go.TextBlock,  // slack
							new go.Binding("text", "", function(d) { return (d.lateFinish - (d.earlyStart + d.length)).toFixed(2); }),
							{ row: 2, column: 1, margin: 5, textAlign: "center" }),
		          		$(go.TextBlock, // lateFinish
		            		new go.Binding("text", "lateFinish"),
		            		{ row: 2, column: 2, margin: 5, textAlign: "center" })
		        	)  // end Table Panel
		      	);  // end Node

		    function linkColorConverter(linkdata, elt) {
				var link = elt.part;
				if (!link) return blue;
				var f = link.fromNode;
				if (!f || !f.data || !f.data.critical) return blue;
				var t = link.toNode;
				if (!t || !t.data || !t.data.critical) return blue;
				return pink;  // when both Link.fromNode.data.critical and Link.toNode.data.critical
			}

		    myDiagram.linkTemplate =
				$(go.Link,
					{ toShortLength: 6, toEndSegmentLength: 20 },
					$(go.Shape,
						{ strokeWidth: 4 },
						new go.Binding("stroke", "", linkColorConverter)),
					$(go.Shape,  // arrowhead
						{ toArrow: "Triangle", stroke: null, scale: 1.5 },
						new go.Binding("fill", "", linkColorConverter))
				);

			this.diagram = myDiagram
			this.updateModel(this.modelData)
		},
		watch:{
			modelData(val) { 
				this.updateModel(val) 
			}
		},
		methods: {
			model: function() { return this.diagram.model; },
			updateModel: function(val) {
				// No GoJS transaction permitted when replacing Diagram.model.
				if (val instanceof go.Model) {
					this.diagram.model = val;
				} else {
					var m = new go.GraphLinksModel()
					if (val) {
						for (var p in val) {
							m[p] = val[p];
						}
					}
					this.diagram.model = m;
				}
	        },
	        updateDiagramFromData: function() {
				this.diagram.startTransaction();
				// This is very general but very inefficient.
				// It would be better to modify the diagramData data by calling
				// Model.setDataProperty or Model.addNodeData, et al.
				this.diagram.updateAllRelationshipsFromData();
				this.diagram.updateAllTargetBindings();
				this.diagram.commitTransaction("updated");
	        }
		}
	}
</script>