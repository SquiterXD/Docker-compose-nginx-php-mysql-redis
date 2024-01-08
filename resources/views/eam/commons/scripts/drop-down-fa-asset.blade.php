
<script>
  var dataDropDownFaAsset= []
  $.ajax({
    url: "{{ route('eam.ajax.lov.fa-asset') }}",
    method: 'GET',
    success: function (response) {
      dataDropDownFaAsset= response.data.filter(row => {
        row.codeLov = row.asset_number
        row.descLov = row.description
        row.codeDescLov = row.asset_number + ' : ' + row.description
        return row
      })
      autocomplete(document.getElementById("faNumber"), dataDropDownFaAsset, document.getElementById("faNumberBtn"));
    },
    error: function (jqXHR, textStatus, errorRhrown) {
      swal("Error", jqXHR.responseJSON.message, "error");
    }
  })

  function autocomplete(inp, arr, inp2) {
    inp.addEventListener("input", function(e) {
      var a, b, i, val = this.value;
      closeAllLists();
      a = document.createElement("DIV");
      a.setAttribute("id", this.id + "autocomplete-list");
      a.setAttribute("class", inp.id+"autocomplete-items autocomplete-items");
      this.parentNode.appendChild(a);
      $.ajax({
        url: "{{ route('eam.ajax.lov.fa-asset') }}",
        method: 'GET',
        data: {
          'search_param': val,
        },
        success: function (response) {
          arr = response.data.filter(row => {
            row.codeLov = row.asset_number
            row.descLov = row.description
            row.codeDescLov = row.asset_number + ' : ' + row.description
            return row
          })

          for (i = 0; i < arr.length; i++) {
            b = document.createElement("DIV");
            b.innerHTML += (arr[i].codeLov + ' : ' + arr[i].descLov);
            b.innerHTML += "<input type='hidden' value='" + arr[i].codeLov + ' : ' +  arr[i].descLov + "'>";
            b.addEventListener("click", function(e) {
                checkclick = true
                inp.value = this.getElementsByTagName("input")[0].value;
                closeAllLists();
            });
            a.appendChild(b);
          }
        },
        error: function (jqXHR, textStatus, errorRhrown) {
          swal("Error", jqXHR.responseJSON.message, "error");
        }
      }) 
    });
    inp.addEventListener("keydown", function(e) {
        var x = document.getElementById(this.id + "autocomplete-list");
        if (x) x = x.getElementsByTagName("div");
    });
    function closeAllLists(elmnt) {
      var x = document.getElementsByClassName(inp.id+"autocomplete-items autocomplete-items");
      for (var i = 0; i < x.length; i++) {
        if (elmnt != x[i] && elmnt != inp) {
          x[i].parentNode.removeChild(x[i]);
        }
      }
    }
    var checkclick = true

    function closeAllLists2(elmnt) {
      let checkData = true
      arr.filter(row => {
        if (row.codeLov == inp.value || row.descLov == inp.value || row.codeDescLov == inp.value) {
          inp.value = row.codeLov + ' : ' +  row.descLov
          checkclick = true
          checkData = false
        }
      })
    
      if (checkData) {
        inp.value = ''
      }

      var x = document.getElementsByClassName(inp.id+"autocomplete-items autocomplete-items");
      for (var i = 0; i < x.length; i++) {
        if (elmnt != x[i] && elmnt != inp && elmnt != inp2) {
          checkclick = true
          x[i].parentNode.removeChild(x[i]);
        }
      }
    }
    document.addEventListener("click", function (e) {
      closeAllLists2(e.target);
    });
    inp2.addEventListener("click", function(e) {
      if (checkclick) {
        checkclick = false
        closeAllLists();
        var a, b, i, val = inp.value;
        a = document.createElement("DIV");
        a.setAttribute("id", this.id + "autocomplete-list");
        a.setAttribute("class", inp.id+"autocomplete-items autocomplete-items");
        this.parentNode.appendChild(a);
        for (i = 0; i < arr.length; i++) {
          b = document.createElement("DIV");
          b.innerHTML += (arr[i].codeLov + ' : ' + arr[i].descLov);
          b.innerHTML += "<input type='hidden' value='" + arr[i].codeLov + ' : ' +  arr[i].descLov + "'>";
          b.addEventListener("click", function(e) {
            inp.value = this.getElementsByTagName("input")[0].value;
            closeAllLists();
          });
          a.appendChild(b);
        }
      }
    });
  }

  
</script>