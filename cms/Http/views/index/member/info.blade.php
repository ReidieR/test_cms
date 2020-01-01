 {{-- 个人资料组件 --}}
<template id="infotmp">
  <div class="laui-row">
    <div class="member-content-header">
      <h3>个人资料</h3>
    </div>
    @include('index.public.success')
    @include('index.public.errors')
    <form class="form-horizontal" @submit="checkForm()" :action="'/member/' + selfData.user_id + '/save'" method="POST">
      @csrf
      <div class="form-group" id="user_avator">
        <label class="col-sm-2 control-label"><img name="avator" :src="selfData.avator" alt="" style="width:100px;height:100px;border-radius:50%"></label>
        <div class="col-sm-6">
          <input type="hidden" name="avator" :value="selfData.avator">
          <div id="uploader-demo">
            <!--用来存放item-->
            <div id="fileList" class="uploader-list"></div>
            <div id="filePicker">选择图片</div>
          </div>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-2 control-label">ID</label>
        <div class="col-sm-6">
          <input type="text" name="user_id" disabled :value="selfData.user_id" class="form-control" />
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-2 control-label">用户名</label>
        <div class="col-sm-6">
          <input
            type="text"
            name="username"
            v-model="selfData.username"
            autocomplete="off"
            class="form-control"
          />
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-2 control-label">邮箱</label>
        <div class="col-sm-6">
          <input
            type="text"
            name="email"
            v-model="selfData.email"
            autocomplete="off"
            class="form-control"
          />
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-2 control-label">电话</label>
        <div class="col-sm-6">
          <input
            type="text"
            name="mobile"
            v-model="selfData.mobile"
            autocomplete="off"
            class="form-control"
          />
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-2 control-label">注册时间</label>
        <div class="col-sm-6">
          <input
            type="text"
            name="created_at"
            disabled
            :value="selfData.created_at"
            autocomplete="off"
            class="form-control"
          />
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-2 control-label"></label>
        <div class="col-sm-6">
          <button type="submit" class="btn btn-success">保存</button>
        </div>
      </div>
    </form>
  </div>
</template>

  