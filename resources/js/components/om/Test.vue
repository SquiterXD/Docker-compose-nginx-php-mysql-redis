<template>
  <div>
    <div class="subjects-content">
     <h3 class="subjects-trimester-title">Self Evaluation Page</h3>

        <div class="self-evaluation-rows">
                Number of Rows:   
                <input type="text" name="rows" class="rows-textbox">
                <div class="btn btn-blueviolet btn-inline-block btn-create">Create</div>
                <div class="btn btn-blueviolet btn-inline-block btn-create" @click="addRow">Add Row</div>
        </div>

        <div class="box-body box-self-evaluation">
            <table id="example2" class="table table-hover table-striped sortable">
                <thead>
                    <tr>
                        <th>Subject Area</th>
                        <th>Section</th>
                        <th>Grade</th>
                        <th>Course Title</th>
                        <th>Remove</th>
                    </tr>
                </thead>
                
                <tbody>
                    <tr v-for="row in rows">
                        <td>
                          <select>
                          <option>- - - -</option><br>
                          <option value="CS101">CS101</option>
                          <option value="CS102">CS102</option>
                          </select>
                        </td>
                        <td>
                          <select>
                          <option>- - - -</option><br>
                          <option value="IP">IP</option>
                          <option value="IQ">IQ</option>
                          </select>
                        </td>
                         <td>
                          <select>
                          <option>- - - -</option><br>
                          <option value="A+">A+</option>
                          <option value="A">A</option>
                          </select>
                        </td>
                     
                        <td>
                          <button type="button" @click="removeRow(row)" class="fa fa-remove delete-button"></button>
                        </td>
                     </tr>       
                </tbody>
             </table>             
          </div>
    </div> 
  </div>
</template>

<script>
export default {
  data() {
    return {
      rows: []
    };
  },
   methods:{
    addRow: function(){
      this.rows.push({});
    },
    removeRow: function(row){
      //console.log(row);
      this.rows.$remove(row);
    }
  }
};
</script>