
function articleJson() {
    var e = new Object;
    var t = $("#message-block > .message");
    t.each(function () {
            var t = $(this).find(".prix-boisson").attr("id");
            var n = $(this).find(".count").text();
            e[t] = n
        });
    if (t.size() == 0) {
        return 0
    } else {
        return JSON.stringify(e)
    }
}

function imprimerCommandes() {
    var e = [];
    $("input:checked").each(function () {
            e.push(this.value)
        });
    $.ajax({
            type: "POST",
            url: "/imprimer/commandes",
            data: {
                id: e
            },
            success: function () {
                notify("Succès", "Les commandes vont être imprimées", {
                        closeDelay: 3e3
                    })
            }
        })
}

function imprimer() {
    var e = $("#table-id").val();
    if (isNaN(e) || e == "") {
        var t = articleJson();
        if (t == 0) {
            notify("Erreur", "La commande est vide", {
                    closeDelay: 3e3
                })
        } else {
            $.modal.prompt("Entrez le numéro de table", function (e) {
                    e = parseInt(e);
                    if (isNaN(e)) {
                        $(this).getModalContentBlock().message("Valeur incorrecte", {
                                append: false,
                                type: "number",
                                classes: ["red-gradient"]
                            });
                        return false
                    }
                    $.ajax({
                            type: "POST",
                            url: "/save/commande",
                            data: {
                                table_id: e,
                                commande: app.collections.commande.toJSON()
                            },
                            success: function () {
                                notify("Succès", "La commande va être imprimée", {
                                        closeDelay: 3e3
                                    });
                                clearCommande()
                            }
                        })
                })
        }
    } else {
        notify("Succès", "La facture finale va être imprimée", {
                closeDelay: 3e3
            });
        notify("Succès", "N'oubliez pas d'encaisser l'argent !", {
                closeDelay: 3e3
            });
        chargerPage("payment")
    }
}

function encaisser(e) {
    var t = $("#payment-block > p.message").size();
    var n = 0;
    var r = 0;
    var i = 0;
    var s = 0;
    var o = articleJson();
    if (t > 0) {
        $("#payment-block > p.message").each(function (e) {
                n += Math.abs(parseFloat($(this).find(".prix-boisson").text()))
            })
    }
    if ($("#table-id").val() > 0) {
        var r = $("#table-id").val();
        var u = "/commande/archiver/" + r
    } else if ($("#commande-id").val() > 0) {
        var i = $("#commande-id").val();
        var u = "/commande/archiver/commande/" + $("#commande-id").val()
    } else {
        var u = "/save/commande"
    }
    var a = parseFloat($(".total-euro").text());
    if (a == 0 && t == 0) {
        notify("Erreur", "La commande est vide", {
                closeDelay: 3e3
            })
    } else if (a <= 0 || e == 1) {
        if ($(".cashback").text()) {
            var f = parseFloat($(".cashback").text());
            s = f
        }
        if (e == 1) {
            e = parseFloat($(".total-euro").text()) + s
        }
        $.ajax({
                type: "POST",
                url: u,
                data: {
                    cashback: s,
                    bancontact: e,
                    cash: n,
                    commande: app.collections.commande.toJSON()
                },
                success: function () {
                    notify("Succès", "La commande va être imprimée", {
                            closeDelay: 3e3
                        });
                    clearCommande()
                }
            });
        notify("Succès", "La commande va être archivée", {
                closeDelay: 3e3
            });
        clearCommande()
    } else if (a > 0 && t != 0 && e == 0) {
        notify("Erreur", "Il manque de l'argent !", {
                closeDelay: 3e3
            })
    } else {
        chargerPage("payment")
    }
}

function chargerCommande() {
    var e = parseFloat($(".total-euro").text());
    if (e > 0) {
        notify("Erreur", "Vous avez déja une commande en cours", {
                closeDelay: 3e3
            })
    } else {
        $.modal.prompt("Entrez le numéro de table", function (e) {
                e = parseInt(e);
                if (isNaN(e)) {
                    $(this).getModalContentBlock().message("Valeur incorrecte", {
                            append: false,
                            type: "number",
                            classes: ["red-gradient"]
                        });
                    return false
                }
                jsonCommande("", e);
                $("#table_id").attr("val", e)
            })
    }
}

function jsonCommande(e, t) {
    var n;
    if (t != undefined && t != "") {
        n = "/get/commande/table_id/" + t + ".json"
    } else {
        n = "/get/commande/id/" + e + ".json"
    }
    $.getJSON(n, function (n) {
            $(".total-euro").html(n["reste_a_paye"]);
            if (n["reste_a_paye"] == "") {
                notify("Erreur", "Il n'y a pas de commande en cours pour cette table", {
                        closeDelay: 3e3
                    })
            } else {
                $.each(n["articles"], function (e, t) {
                        for (i = 0; i < t[1]; i++) {
                            addBoisson(t[2], e, t[0])
                        }
                    });
                $("#table-id").attr("value", t);
                $("#commande-id").attr("value", e);
                chargerPage("payment");
                $("#imprimer").attr("title", "Imprimer la facture")
            }
        })
}

function payment() {
    $("ul.gallery li a.articles-message").click(function (e) {
            var t = $(this).data("title");
            var n = $(this).data("price");
            var r = $(this).attr("id");
            addBoisson(n, t, r);
            e.preventDefault()
        });
    $("ul.gallery li a.articles-message").longclick(200, function (e) {
            var t = $(this).data("title");
            var n = $(this).data("price");
            var r = $(this).attr("id");
            $.modal.prompt("Entrez le nombre d'article", function (s) {
                    s = parseInt(s);
                    if (isNaN(s)) {
                        $(this).getModalContentBlock().message("Valeur incorrecte", {
                                append: false,
                                type: "number",
                                classes: ["red-gradient"]
                            });
                        return false
                    }
                    for (i = 0; i < s; i++) {
                        e.preventDefault();
                        addBoisson(n, t, r)
                    }
                })
        })
}

function addBoisson(e, t, n) {
    if ($.template.mediaQuery.isSmallerThan("tablet-portrait")) {
        notify("Ajout d'un article", t, {
                closeDelay: 500
            })
    }
    var r = {
        name: t,
        prix: e,
        id: n
    };
    if (findArticle = app.collections.commande.get(n)) {
        findArticle.set({
                count: findArticle.get("count") + 1
            })
    } else {
        app.collections.commande.add(r)
    }
    $("#commandeDetails").attr("open", "open");
    updatePrixTotal()
}

function updatePrixTotal() {
    var e = 0;
    $("p.message").each(function (t) {
            nb_boisson = 1;
            var n = parseFloat($(".prix-boisson", this).text());
            if ($(".count", this).length) nb_boisson = $(".count", this).text();
            e += n * nb_boisson
        });
    $(".total-euro").html(e.toFixed(2));
    var t = 0;
    if ($(".cashback").text()) {
        var n = parseFloat($(".cashback").text());
        t = n
    }
    $(".cashback-euro").html(t.toFixed(2))
}

function clearCommande() {
    app.collections.commande.reset();
    $("p.message").remove();
    chargerPage("commande");
    $("#table-id").attr("value", "");
    $("#commande-id").attr("value", "");
    $("#imprimer").attr("title", "Imprimer la commande");
    updatePrixTotal()
}

function dataTableInit(e) {
    var t = $("#" + e);
    t.dataTable({
            aoColumnDefs: [{
                    asSorting: ["desc"],
                    aTargets: [3],
                    bSortable: false,
                    aTargets: [0]
                }
            ],
            sPaginationType: "full_numbers",
            sDom: '<"dataTables_header"lfr>t<"dataTables_footer"ip>',
            bJQueryUI: true,
            oLanguage: {
                sProcessing: "Traitement en cours...",
                sSearch: "Rechercher :",
                sLengthMenu: "Afficher _MENU_ éléments",
                sInfo: "Affichage de l'élement _START_ à _END_ sur _TOTAL_ éléments",
                sInfoEmpty: "Affichage de l'élement 0 à 0 sur 0 éléments",
                sInfoFiltered: "(filtré de _MAX_ éléments au total)",
                sInfoPostFix: "",
                sLoadingRecords: "Chargement en cours...",
                sZeroRecords: "Aucun élément à afficher",
                sEmptyTable: "Aucune donnée disponible dans le tableau",
                oPaginate: {
                    sFirst: "Premier",
                    sPrevious: "Précédent",
                    sNext: "Suivant",
                    sLast: "Dernier"
                },
                oAria: {
                    sSortAscending: ": activer pour trier la colonne par ordre croissant",
                    sSortDescending: ": activer pour trier la colonne par ordre décroissant"
                }
            },
            fnInitComplete: function (e) {
                t.closest(".dataTables_wrapper").find(".dataTables_length select").addClass("select glossy").styleSelect();
                tableStyled = true
            }
        })
}

function editRow(e, t) {
    var n;
    var r = {
        Valider: function (e) {
            $(this).parent().prev().find("form").submit();
            e.closeModal()
        },
        Annuler: function (e) {
            e.closeModal()
        }
    };
    if (!t) {
        n = "/new/" + e + ""
    } else {
        n = "/edit/" + e + "/" + t
    }
    $.modal({
            title: "Edition",
            resizable: false,
            url: n,
            buttonsAlign: "center",
            buttons: r
        })
}

function deleteRow(e, t) {
    var n = "/delete/" + e + "/" + t;
    $.ajax({
            type: "GET",
            url: n
        });
    $("#" + e + "-" + t).hide()
}

function deleteCommande(e, t) {
    var n = "/delete/" + e + "/" + t;
    $.ajax({
            type: "GET",
            url: n
        });
    $("#article-" + t).hide();
    $("#row-drop-" + t).hide()
}

function validerForm(e, t) {
    if (t == null) {
        var n = "POST";
        var r = "/rest/" + e + ".xml"
    } else {
        var n = "PUT";
        var r = "/rest/" + e + "/" + t + ".xml"
    }
    var i = $("input, select");
    var s = new Object;
    i.each(function () {
            var e = $(this).attr("name");
            var t = $(this).val();
            s[e] = t
        });
    $.ajax({
            type: n,
            url: r,
            data: s
        });
    return false
}

function chargerPage(e) {
    if (e == "payment") {
        var t = "/payment"
    } else if (e == "commande") {
        var t = "/"
    } else if (e == "gestion/utilisateur") {
        var t = "/gestion/utilisateur"
    } else if (e == "gestion/article") {
        var t = "/gestion/article"
    } else if (e == "gestion/stock") {
        var t = "/gestion/stock"
    } else if (e == "gestion/commande") {
        var t = "/gestion/commande"
    } else if (e == "gestion/outils") {
        var t = "/gestion/outils"
    } else if (e == "stat") {
        var t = "/stat"
    }
    
    $.ajax(t, {
        dataType: "html",
        cache: false,
        success: function(data, textStatus, jqXHR) {
            $('#main').html(data);
            payment();
            $(".shortcuts-open").removeClass("shortcuts-open")
        },
        complete: function(jqXHR, textStatus) {
        }
    });    
    
    

    return false
}




function setStatutCommande(e, t) {
    var n = "/set/statut/commande/" + e + "/" + t;
    $.ajax({
            type: "GET",
            url: n,
            success: function () {
                notify("Succès", "Le statut de la commande a été modifié", {
                        closeDelay: 3e3
                    })
            }
        })
}

function Commentaire(e) {
    var t = {
        Valider: function (t) {
            var n = $("#autoexpanding").val();
            findArticle = app.collections.commande.get(e);
            findArticle.set({
                    comment: n
                });
            t.closeModal()
        },
        Annuler: function (e) {
            e.closeModal()
        }
    };
    $.modal({
            title: "Ajoutez un commentaire",
            url: "/commande/commentaire",
            buttonsAlign: "center",
            buttons: t
        })
}

function getArticlesCommande(e) {
    setStatutCommande(e, 3);
    article = "";
    $.getJSON("/get/commande/id/" + e + ".json", function (t) {
            console.log(t["articles"]);
            $.each(t["articles"], function (e, t) {
                    article += '<h3 class="no-margin-bottom no-margin-top" ><span class="tag">' + t[1] + "</span> x <strong> " + e + " </strong></h3><br/>" + t[3] + "</br>"
                });
            var n = {
                "Prête": function (t) {
                    $("#commandeLive-" + e).remove();
                    setStatutCommande(e, 4);
                    app.collections.commandeLive.remove;
                    t.closeModal()
                },
                Encaisser: function (t) {
                    jsonCommande(e, "");
                    $(".menu-open").removeClass("menu-open");
                    t.closeModal()
                },
                Annuler: function (e) {
                    e.closeModal()
                }
            };
            $.modal({
                    title: "Ajoutez un commentaire",
                    content: article,
                    buttonsAlign: "center",
                    buttons: n
                })
        })
}

function deleteArticleCommande(e) {
    $("#article-" + e).parent().parent().hide();
    findArticle = app.collections.commande.get(e);
    app.collections.commande.remove(findArticle);
    updatePrixTotal()
}
$(".close-menu").click(function (e) {
        $("body").removeClass("menu-open")
    });
$("#main").click(function (e) {
        $(".shortcuts-open").removeClass("shortcuts-open")
    });
$(document).ready(function () {
        setInterval(function () {
                var e;
                if ($.template.mediaQuery.isSmallerThan("tablet-landscape")) {
                    var t = "/live/commande/mobile";
                    var n = "Commande prête"
                } else {
                    var t = "/live/commande/general";
                    var n = "Nouvelle commande"
                }
                $.getJSON(t, function (e) {
                        app.collections.commandeLive.reset();
                        for (var t = 0; t < e.length; t++) {
                            var r = {
                                id: e[t]["id"],
                                serverPrenom: e[t]["serverPrenom"],
                                serverNom: e[t]["serverNom"],
                                table_id: e[t]["table_id"],
                                clientNom: e[t]["clientNom"],
                                statut_commande: e[t]["statut_commande"],
                                statut_id: e[t]["statut_id"]
                            };
                            if (app.collections.commandeLive.get(e[t]["id"]) == undefined) {
                                app.collections.commandeLive.add(r);
                                $("#commandeLiveDetails").attr("open", "open");
                                notify("Notification", n, {
                                        closeDelay: 3e3
                                    })
                            }
                        }
                    })
            }, 5e3)
    })