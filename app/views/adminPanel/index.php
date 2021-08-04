<?php require APPROOT . '/views/inc/header.php'; ?>


<div class="container">
    <br/>
    <br/>
    <br/>
    <div class="table-responsiv">
        <h3 align="center">Student Table</h3><br/>
        <table id="editable_table" class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>ID</th>
                <th>Nume</th>
                <th>Prenume</th>
                <th>Categorie</th>
                <th>Data_plata</th>
                <th>Numar chitanta</th>
                <th>Numar platii restante</th>
            </tr>
            </thead>
            <tbody>

            <?php
            if (isset($data)) {
                foreach ($data['users'] as $user) :
                    echo '
<tr>
<td>' . $user->id . '</td>
<td>' . $user->fname . '</td>
<td>' . $user->lname . '</td>
<td>' . $user->Categorie . '</td>
<td>' . $user->Data_plata . '</td>
<td>' . $user->Nr_chitanta . '</td>
<td>' . $user->Nr_plati_restante . '</td>       
</tr>
';
                endforeach;
            }
            ?>

            </tbody>
        </table>
    </div>


    <?php require APPROOT . '/views/inc/footer.php'; ?>

    <script>
        $(document).ready(function () {
            $('#editable_table').Tabledit({
                url:'<?php echo URLROOT;?>/adminPanel/edit',
                dataType:'json',
                deleteButton: false,
                columns: {
                    identifier: [0, 'id'],
                    editable: [[1, 'fname'], [2, 'lname'], [3, 'Categorie', '{"Buget":"Buget", "Taxa": "Taxa"}'], [4, 'Data_plata'], [5, 'Nr_chitanta'], [6, 'Nr_plati_restante']]
                },
                restoreButton: false,
                onSuccess: function (data, textStatus, jqXHR) {
                   if(data.success){
                        location.reload();
                   }
                }
            });
        });
    </script>
