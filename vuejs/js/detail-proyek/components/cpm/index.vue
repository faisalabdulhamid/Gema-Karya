<template lang="html">
  <div class="ui container">
    <div class="ui tall stacked segment">
      <h1>DIAGRAM NetWORK</h1>

      <diagram ref="diag"
             v-bind:model-data="diagramData"
             v-on:model-changed="modelChanged"
             v-on:changed-selection="changedSelection"
             style="border: solid 1px black; width:100%; height:400px"></diagram>

    
    </div>
  </div>
</template>

<script>

export default {
  name: "DetailPegawaiIndex",
  data(){
    return {
      diagramData: {  // passed to <diagram> as its modelData
        nodeDataArray: [
          // { key: 1, text: "Start", length: 0, earlyStart: 0, lateFinish: 0, critical: true },
          // { key: 2, text: "a", length: 4, earlyStart: 0, lateFinish: 5, critical: true },
          // { key: 3, text: "b", length: 5.33, earlyStart: 0, lateFinish: 9.17, critical: false },
          // { key: 4, text: "c", length: 5.17, earlyStart: 4, lateFinish: 9.17, critical: true },
          // { key: 5, text: "d", length: 6.33, earlyStart: 4, lateFinish: 15.01, critical: false },
          // { key: 6, text: "e", length: 5.17, earlyStart: 9.17, lateFinish: 14.34, critical: true },
          // { key: 7, text: "f", length: 4.5, earlyStart: 10.33, lateFinish: 19.51, critical: false },
          // { key: 8, text: "g", length: 5.17, earlyStart: 14.34, lateFinish: 19.51, critical: true },
          // { key: 9, text: "Finish", length: 0, earlyStart: 19.51, lateFinish: 19.51, critical: true }
        ],
        linkDataArray: [
          // { from: 1, to: 2 },
          // { from: 1, to: 3 },
          // { from: 2, to: 4 },
          // { from: 2, to: 5 },
          // { from: 3, to: 6 },
          // { from: 4, to: 6 },
          // { from: 5, to: 7 },
          // { from: 6, to: 8 },
          // { from: 7, to: 9 },
          // { from: 8, to: 9 }
        ]
      },
      currentNode: null,
      savedModelText: "",
    }
  },
  computed: {
    currentNodeText: {
      get: function() {
        var node = this.currentNode;
        if (node instanceof go.Node) {
          return node.data.text;
        } else {
          return "";
        }
      },
      set: function(val) {
        var node = this.currentNode;
        if (node instanceof go.Node) {
          var model = this.model();
          model.startTransaction();
          model.setDataProperty(node.data, "text", val);
          model.commitTransaction("edited text");
        }
      }
    }
  },
  methods: {
    // get access to the GoJS Model of the GoJS Diagram
    model: function() { return this.$refs.diag.model(); },

    // tell the GoJS Diagram to update based on the arbitrarily modified model data
    updateDiagramFromData: function() { this.$refs.diag.updateDiagramFromData(); },

    // this event listener is declared on the <diagram>
    modelChanged: function(e) {
      if (e.isTransactionFinished) {  // show the model data in the page's TextArea
        this.savedModelText = e.model.toJson();
      }
    },

    changedSelection: function(e) {
      var node = e.diagram.selection.first();
      if (node instanceof go.Node) {
        this.currentNode = node;
        this.currentNodeText = node.data.text;
      } else {
        this.currentNode = null;
        this.currentNodeText = "";
      }
    },
    getData(){
      var that = this
      this.$http.get('/cpm').then(res => {
        Vue.set(that.$data, 'diagramData', res.data)
        // Vue.set(that.$data, 'diagramData', res.data.linkDataArray)
        // console.log(res.data.nodeDataArray)
        // console.log(this.diagramData.nodeDataArray)
      })
    }
    
  },
  created(){
    this.getData()
  },
  components:{
    diagram: require('./diagram-network')
  }
}
</script>
