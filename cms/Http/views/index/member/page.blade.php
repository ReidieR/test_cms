{{-- 个人文章展示组件 --}}
<template id="pagetmp">
  <div class="laui-row">
    <div class="member-content-header">
      <h3>我的文章</h3>
    </div>
    <div id="member_conllect_article_box" v-if="parentData != 0">
      <div v-for="item in parentData" :key="item.aid"  class="panel panel-default">
        <div class="panel-heading">
        <a :href="'/detail/'+item.aid">@{{item.title}}</a>
        <span @click="articleEdit(item.aid)" data-toggle="modal" data-target="#pageModal">编辑</span>
        </div>
        <div class="panel-body">
        <p>简介：@{{item.descs}}</p>          
        </div>
      </div>
    </div>
    <div id="member_conllect_article_box " v-else>
      <div>
        <h1 style="margin-top:180px;text-align:center;">这里空空如也</h1>
      </div>
    </div>
  <comedit :article-data="articleData" @childfun="dataChange" ></comedit>
  </div>
</template>
{{-- 文章编辑组件 --}}
<template id="pageChildren">
  <div class="modal fade bs-example-modal-lg" ref="model" id="pageModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">文章编辑</h4>
        </div>
        <div class="modal-body">
          <form action="">
            <input type="hidden" name="_token" ref="_token" value={{csrf_token()}}>
            <div class="form-group">
            <label for="">标题</label>
            <input type="text" class="form-control" v-model:value="articleData.title">
            </div>
            <div class="form-group">
              <label for="">分类</label>
            <select  class="form-control" ref="select">
              <option value="0">请选择</option>
              <option v-for="item in articleData.cates" 
                      :key="item.art_cate_id" 
                      :value="item.art_cate_id"
                      :selected="item.art_cate_id == articleData.cate_id ? 'true' : 'false'"
            >@{{item.art_cate_title}}</option>
            </select>
            </div>
          </form>
          <div id="articleEditor">
            <script id="container" name="content" type="text/plain">     
            </script> 
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
          <button type="button" class="btn btn-primary" @click="articleSave(articleData.aid)">保存修改</button>
        </div>
      </div>
    </div>
  </div>
</template>
