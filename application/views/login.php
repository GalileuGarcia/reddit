<?php $this->load->view('commons/head'); ?>

<div class="container" x-data="{ rightSide: false, leftSide: false }" style="width: 80%;">
    <?php $this->load->view('commons/menu'); ?>
    <div class="main">
        <div class="main-container">
            <div class="album box">
                <div class="status-main">
                    <div class="row" style="width: 100%; padding-left: 3% ">
                    <form method="POST" action="<?= base_url('login/acessar');?>">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Digite o usuário</label>
                            <input type="text" class="form-control" name="usuario" required="">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Senha</label>
                            <input type="password" name="senha" class="form-control" required="">
                        </div>
                        
                        <button type="submit" class="btn btn-primary">ACESSAR</button>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
