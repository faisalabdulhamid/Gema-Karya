<script>
import { Line } from 'vue-chartjs'

export default {
  extends: Line,
  props: ['data', 'options'],
  data(){
  	return {
  		data2: {
  			"labels": [
	            "Minggu ke -1",
	            "Minggu ke -2",
	            "Minggu ke -3",
	            "Minggu ke -4",
	            "Minggu ke -5",
	            "Minggu ke -6",
	            "Minggu ke -7"
	        ],
	        "datasets": [
	            {
	                "label": "BCWS",
	                "data": [
	                    7449328,
	                    13194406,
	                    19513180,
	                    53335082,
	                    71572028,
	                    74224019,
	                    75169655
	                ],
	                "fill": false,
	                "borderColor": "#4286f4"
	            },
	            {
	                "label": "BCWP",
	                "data": [
	                    10,
	                    15033971
	                ],
	                "fill": false,
	                "borderColor": "#42f456"
	            },
	            {
	                "label": "ACWP",
	                "data": [
	                    200000,
	                    700000
	                ],
	                "fill": false,
	                "borderColor": '#d61d58'
	            }
	        ]
  		}
  	}
  },
  created(){
    console.log(JSON.stringify(this.options))
    console.log(JSON.stringify(this.data))
  },
  mounted () {
    this.renderChart(this.data, this.options)
  },
  destroyed(){
  	console.log("destroyed")
  }
}
</script>