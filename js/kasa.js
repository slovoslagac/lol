
function articles(event, val, amount, type) {
    if (event.button == 0) {
        add_product(val, amount, type);
    } else if (event.button == 2) {
        if(billstatus < 0 ) {
            add_product(val, 0, type);
        }
        removeArticle(val, amount, type);
    }
}

function add_product(val, amount, type) {
    var code = val + '_' + type;
    var price = parseFloat(document.getElementById('price' + val).innerText);
    var articlename = document.getElementById('articlename' + val).innerText;
    if (productsID.indexOf(code) > -1) {
        addArticle(val, amount, type);
    }
    else {
        productsID.push(code);
        var objTo = document.getElementById('billBody');
        var divadd = document.createElement("div");
        divadd.setAttribute("id", "checkproduct" + code);
        if (type == 0) {
            divadd.innerHTML = '<div class="bill-row" id="article' + code + '" ><input type="hidden" name="na' + code + '" id="na' + code + '" value="' + amount + '"><input type="hidden" name = "type' + code + '" id = "type' + code + '" value="' + type + '"><strong id="numarticle' + code + '">' + amount + '</strong></input><strong> x ' + articlename + '</strong><span id="checkprice' + code + '">' + price + '</span><div class="plusminus"><i class="icon-plus" onclick="addArticle(' + val + ', 1, ' + type + ')"></i><i class="icon-minus" onclick="removeArticle(' + val + ', 1, ' + type + ')"></i></div></div>';
        } else if (articlename.indexOf('3h') == -1 ) {
            divadd.innerHTML = '<div class="bill-row" id="article' + code + '" ><input type="hidden" name="na' + code + '" id="na' + code + '" value="' + amount + '"><input type="hidden" name = "type' + code + '" id = "type' + code + '" value="' + type + '"><strong id="numarticle' + code + '">' + amount*60 + '</strong></input><strong> x (#' + type + ') ' + articlename + '</strong><span id="checkprice' + code + '">' + price + '</span><div class="plusminus"><i class="icon-plus" onclick="addArticle(' + val + ', 1, ' + type + ')"></i><i class="icon-minus" onclick="removeArticle(' + val + ', 1, ' + type + ')"></i></div></div>';
        } else {
            divadd.innerHTML = '<div class="bill-row" id="article' + code + '" ><input type="hidden" name="na' + code + '" id="na' + code + '" value="' + amount + '"><input type="hidden" name = "type' + code + '" id = "type' + code + '" value="' + type + '"><strong id="numarticle' + code + '">' + amount + '</strong></input><strong> x (#' + type + ') ' + articlename + '</strong><span id="checkprice' + code + '">' + price + '</span><div class="plusminus"><i class="icon-plus" onclick="addArticle(' + val + ', 1, ' + type + ')"></i><i class="icon-minus" onclick="removeArticle(' + val + ', 1, ' + type + ')"></i></div></div>';
        }
        objTo.appendChild(divadd)
        product = product + amount;
    }
    calculateSum();
}


function addArticle(val, amount, type) {
    var code = val + '_' + type;
    var currVal = parseFloat(document.getElementById('na' + code).value);
    var articlename = document.getElementById('articlename' + val).innerText;

    currVal = currVal + amount;
    if(type > 0 && articlename.indexOf('3h') == -1 ) {
        document.getElementById('numarticle' + code).innerText = String(currVal*60);
    } else {
        document.getElementById('numarticle' + code).innerText = String(currVal);
    }
    document.getElementById('na' + code).setAttribute("value", String(currVal));
    calculateSum();
}

function removeArticle(val, amount, type) {
    var code = val + '_' + type;
    var currVal = document.getElementById('na' + code).value;
    var articlename = document.getElementById('articlename' + val).innerText;
    currVal = currVal - amount;
    if (currVal <= billstatus || currVal == 0) {
        document.getElementById('checkproduct' + code).remove();
        productsID.splice(productsID.indexOf(String(val)), 1);
        product--;
    }
else {
        if(type > 0 && articlename.indexOf('3h') == -1 ) {document.getElementById('numarticle' + code).innerText = String(currVal*60);} else {
        document.getElementById('numarticle' + code).innerText = String(currVal);}

        document.getElementById('na' + code).setAttribute("value", currVal);
    }
    calculateSum();
}


function calculateSum() {
    var Sum = 0;
    var lengthArray = $(productsID).toArray().length;
    if (lengthArray > 0) {
        for (var k = 0; k < lengthArray; k++) {
            var articleId = productsID[k];
            var numArt = document.getElementById('na' + articleId).value;
            var priceArt = parseInt(document.getElementById('checkprice' + articleId).innerText);
            Sum = Sum + numArt * priceArt;
        }
    }
    var hourval = parseInt(document.getElementById("hours").value);
    if (hourval > 0) {
        hourval = hourval
    } else {
        hourval = 0
    }
    ;
    tmpSum = Sum + hourval;
    document.getElementById('sum').innerText = String(tmpSum) + ' Din';
    document.getElementById('billSum').setAttribute("value", String(Sum));
    var normalAmount = testSumCalculation();

    document.getElementById('discount').innerText = String(normalAmount - Sum) + ' Din';
}


function testSumCalculation() {
    var tmpSum = 0;
    var la = $(pricesNormal).toArray().length;
    for (var k = 0; k < la; k++) {
        var tmpobject = pricesNormal[k];
        for (var j = 0; j <= numSony; j++) {
            var tmpindex = productsID.indexOf(String(tmpobject.id + '_' + j));
            if (tmpindex > -1) {
                var numArt = document.getElementById('na' + tmpobject.id + '_' + j).value;
                var priceArt = parseInt(tmpobject.price);
                tmpSum = tmpSum + numArt * priceArt;
            }
        }
    }
    return tmpSum;
}


function recalculate() {
    var val = document.getElementById('selectuser').value.split(' - ')[1];
    var length = 0;
    if (val == 'popust') {
        length = $(pricesPopust).toArray().length;
        for (var i = 0; i < length; i++) {
            var object = pricesPopust[i];
            var id = object.id;
            var price = object.price;
            document.getElementById('price' + id).innerText = String(price) + ' Din';
            if (document.getElementById('checkprice' + id) !== null) {
                document.getElementById('checkprice' + id).innerText = String(price);
            }

        }
    } else if (val == 'normal') {
        length = $(pricesNormal).toArray().length;
        for (var j = 0; j < length; j++) {
            var objectnormal = pricesNormal[j];
            var idnorm = objectnormal.id;
            var pricenorm = objectnormal.price;
            document.getElementById('price' + idnorm).innerText = String(pricenorm) + ' Din';
            if (document.getElementById('checkprice' + idnorm) !== null) {
                document.getElementById('checkprice' + idnorm).innerText = String(pricenorm);
            }
        }
    } else {
        length = $(pricesNormal).toArray().length;
        for (var j = 0; j < length; j++) {
            var objectnormal = pricesNormal[j];
            var idnorm = objectnormal.id;
            var pricenorm = objectnormal.price;
            document.getElementById('price' + idnorm).innerText = String(pricenorm) + ' Din';
            if (document.getElementById('checkprice' + idnorm) !== null) {
                document.getElementById('checkprice' + idnorm).innerText = String(pricenorm);
            }
        }
    }
    calculateSum();
}


function editBill(val) {
    billstatus = 0;
    resetBill();



    document.getElementById("payment").setAttribute("class", "hide");
    document.getElementById("paymentEdit").setAttribute("class", "button btn btn-primary btn-large pay");
    document.getElementById("paymentCancel").setAttribute("class", "button btn btn-primary btn-small pay");
    document.getElementById("paymentDelete").setAttribute("class", "button btn btn-primary btn-small pay");

    for (var l = 0; l < 3; l++) {
        var billobject = billDetails[l];
        if (billobject.id == val) {
            document.getElementById("selectuser").value = billobject.type;
            document.getElementById("billId").setAttribute("value", billobject.id);
            document.getElementById("billNumber").innerText = billobject.id;
            deletestatus = billobject.deletestatus;
            var tmpDetails = billobject.billdata;
            for (var p = 0; p < tmpDetails.length; p++) {
                var tmpproduct = tmpDetails[p];
                var tmpproductid = tmpproduct.id.toString();
                var tmpproducttype = tmpproduct.typepr;
                add_product(tmpproductid, tmpproduct.num, tmpproducttype);

            }
        }
    }




    if (deletestatus == '1') {
        document.getElementById("paymentDelete").style.display = 'none';
    } else if (deletestatus == '0') {
        document.getElementById("paymentDelete").style.display = 'block';
    }

    recalculate()

}

function resetBill() {
    for (var t = 0; t < productsID.length; t++) {
        var val = productsID[t];
        document.getElementById('checkproduct' + val).remove();
    }
    productsID = [];
}
