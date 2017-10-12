<template>
    <form @submit.prevent="beforeSubmit">
        <div class="row">
            <div class="col-sm-4">
                <div :class="{'form-group': true, 'has-error' : errors.has('title')}">
                    <label for="title" class="control-label">Title: </label>
                    <input class="form-control"
                           type="text"
                           name="title"
                           v-validate="'required|alpha'"
                           v-model="product.title"
                           id="title">
                    <span class="help-block"
                          v-show="errors.has('title')">
                        <strong>{{ errors.first('title') }}</strong>
                    </span>
                </div><!-- /.form-group -->
            </div><!-- /.col -->
            <div class="col-sm-4">
                <div :class="{'form-group': true, 'has-error' : errors.has('price')}">
                    <label for="price" class="control-label">Price: </label>
                    <input class="form-control"
                           type="text"
                           name="price"
                           v-validate="'required|regex:^[1-90]+.([1-90][1-90])$'"
                           v-model="product.price"
                           id="price">
                    <span class="help-block"
                          v-show="errors.has('price')">
                        <strong>{{ errors.first('price') }}</strong>
                    </span>
                </div><!-- /.form-group -->
            </div><!-- /.col -->
            <div class="col-sm-4">
                <div :class="{'form-group': true, 'has-error' : errors.has('weight')}">
                     <label for="weight" class="control-label">Weight: </label>
                     <input class="form-control"
                            id="weight"
                            name="weight"
                            v-validate="'required|regex:^[1-90]+.([1-90]+)'"
                            v-model="product.weight"
                            type="text">
                    <span class="help-block"
                          v-show="errors.has('weight')">
                        <strong>{{ errors.first('weight') }}</strong>
                    </span>
                 </div><!-- /.form-group -->
            </div><!-- /.col -->
        </div><!-- /.row -->
        <div class="row">
            <div class="col-sm-6" v-if="categories">
                <div :class="{'form-group': true, 'has-error' : errors.has('category')}">
                     <label for="category" class="control-label">Category: </label>
                     <select class="form-control"
                             id="category"
                             name="category"
                             v-validate="'required'"
                             v-model="product.category">
                         <option v-for="category in categories" :value="category.id">{{ category.name }}</option>
                     </select>
                    <span class="help-block"
                          v-show="errors.has('category')">
                        <strong>{{ errors.first('category') }}</strong>
                    </span>
                 </div><!-- /.form-group -->
            </div><!-- /.col -->
            <div class="col-sm-6" v-if="taxes">
                <div :class="{'form-group': true, 'has-error' : errors.has('tax')}">
                    <label for="tax" class="control-label">Tax: </label>
                    <select class="form-control"
                            id="tax"
                            name="tax"
                            v-validate="'required'"
                            v-model="product.tax">
                        <option v-for="tax in taxes" :value="tax.id">{{ tax.name }}</option>
                    </select>
                    <span class="help-block"
                          v-show="errors.has('tax')">
                        <strong>{{ errors.first('tax') }}</strong>
                    </span>
                </div><!-- /.form-group -->
            </div><!-- /.col -->
        </div><!-- /.row -->
        <div class="row">
           <div class="col-sm-12">
               <div :class="{'form-group': true, 'has-error' : errors.has('description')}">
                   <label for="description" class="control-label">Description</label>
                   <textarea class="form-control"
                             id="description"
                             name="description"
                             v-model="product.description"
                             v-validate="'required|regex:^[a-zA-Z190 .\'\?]+$'">

                   </textarea>
                   <span class="help-block"
                         v-show="errors.has('description')">
                        <strong>{{ errors.first('description') }}</strong>
                    </span>
               </div>
           </div><!-- /.col -->
        </div><!-- /.row -->
        <div class="row">
            <div class="col-sm-6">
                <label class="checkbox-inline">
                    <input type="checkbox" v-model="showUpload"><strong>Upload Image:</strong>
                </label>
            </div><!-- /.col -->
        </div><!-- /.row -->
        <div class="row" v-if="!showUpload" >
            <div class="col-sm-6">
                <div :class="{'form-group': true, 'has-error' : errors.has('image')}">
                    <label>Image Path: </label>
                    <input class="form-control"
                           type="text"
                           id="image"
                           name="image"
                           v-validate="'required|url'"
                           v-model="product.image">
                    <span class="help-block"
                          v-show="errors.has('image')">
                        <strong>{{ errors.first('image') }}</strong>
                    </span>
                </div><!-- /.form-group -->
            </div><!-- /.col -->
            <div class="col-sm-6">
                <div :class="{'form-group': true, 'has-error' : errors.has('thumbnail')}">
                    <label>Thumbnail Path: </label>
                    <input class="form-control"
                           type="text"
                           id="thumbnail"
                           name="thumbnail"
                           v-validate="'url'"
                           v-model="product.thumbnail">
                    <span class="help-block"
                          v-show="errors.has('thumbnail')">
                        <strong>{{ errors.first('thumbnail') }}</strong>
                    </span>
                </div><!-- /.form-group -->
            </div><!-- /.col -->
        </div><!-- /.row -->
        <div class="row" v-else>
            <div class="col-sm-6">
                <div :class="{'form-group': true, 'has-error' : errors.has('upload-image')}">
                    <label for="upload-image" class="control-label">Upload Image: </label>
                    <input type="file"
                           name="upload-image"
                           id="upload-image"
                           accept="image/*"
                           v-validate="'required|image'"
                           @change="setFile">
                    <span class="help-block"
                          v-show="errors.has('upload-image')">
                    <strong>{{ errors.first('upload-image') }}</strong>
                </span>
                </div><!-- /.form-group -->
            </div><!-- /.col -->
            <div class="col-sm-6">
                <div v-if="imageSource">
                    <img class="uploaded-image" :src="imageSource" alt="Uploaded Image"/>
                </div>
            </div><!-- /.col -->
        </div><!-- /.row -->
        <div class="row">
            <div class="col-sm-12">
                <button type="submit" class="btn btn-success pull-left">{{ submitButton }}</button>
                <button type="button" class="btn btn-danger pull-right" @click="cancel">Cancel</button>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </form>
</template>

<script>
    export default {
        props : ['reset', 'cancel', 'oldProduct'],

        data : function() {
            return {
                product : {
                    title : '',
                    price : '',
                    category : '',
                    tax : '',
                    image : '',
                    description : '',
                    weight : '',
                    upload : null,
                    thumbnail : ''
                },
                categories : null,
                taxes : null,
                isEdit : false,
                imageSource : null,
                showUpload : false,
                submitButton : 'Add'
            }
        },

        mounted() {
            this.getCategories();
            this.getTaxes();
            if(this.oldProduct) {
                this.onEdit();
            }
        },

        methods: {
            /**
             * when an open edit form event is trigger it must change  the form from create to edit
             * @return void
             */
            onEdit() {
                this.isEdit = true;
                this.submitButton = 'Edit';
                this.fillOutForm();
            },

            /**
             * uses the current product property to fillout the property form
             * @return void
             */
            fillOutForm() {
                this.product = {
                    id : this.oldProduct.id,
                    title : this.oldProduct.title,
                    price : this.oldProduct.price,
                    category : this.oldProduct.category_id,
                    tax : this.oldProduct.tax_id,
                    image : this.oldProduct.image.path,
                    thumbnail : this.oldProduct.image.thumbnail,
                    description : this.oldProduct.description,
                    weight : this.oldProduct.weight
                };
            },

            /**
             * returns form to the default setting
             * @return void
             */
            refresh() {
                this.isEdit = false;
                this.product = {};
                this.showUpload = false;
                this.submitButton = 'Add';
                this.imageSource = null;
            },

            /**
             * does an ajax request to get the categories
             * @return void
             */
            getCategories() {
                let self = this;
                axios.get(window.Laravel.urls.category_api_url)
                    .then(function (response) {
                        self.categories = response.data.categories;
                    })
                    .catch(function () {
                        self.updateError();
                    });
            },

            /**
             * does an ajax request to get the taxes
             * @return void
             */
            getTaxes() {
                let self = this;
                axios.get(window.Laravel.urls.tax_api_url + '/all')
                    .then(function (response) {
                        self.taxes = response.data.taxes;
                    })
                    .catch(function () {
                        self.updateError();
                    });
            },

            /**
             * when the user selects an image it will set the upload property
             * @return void
             */
            setFile(e) {
                if(!e.target.files.length) return;

                this.product.upload = e.target.files[0];
                let reader = new FileReader();
                reader.readAsDataURL(this.product.upload)

                reader.onload = e => {
                    this.imageSource = e.target.result;
                }
            },

            /**
             *  checks if the form passed validation before submitting results
             *  @return void
             */
            beforeSubmit(){
                let self = this;
                this.$validator.validateAll().then(() => {
                    if (!self.errors.any()) {
                        if(self.isEdit){
                            self.edit();
                        } else {
                            self.ajaxRequest(window.Laravel.urls.product_url);
                        }
                    } else {
                        console.log(self.errors)
                    }
                });
            },

            /**
             *  adds the patch to the method request
             *  @return void
             */
            edit() {
                this.product._method = 'patch';
                this.ajaxRequest(window.Laravel.urls.product_url + '/' + this.product.id);
            },

            /**
             *  performs an ajax request and updates the user message
             *  @return void
             */
            ajaxRequest(url) {
                let self = this;
                let form = this.appendFormData();
                axios.post(url, form)
                    .then(function (response) {
                        self.updateMessage(response.data.message);
                    })
                    .catch(function () {
                        self.updateError()
                    });
            },

            /**
             *  creates a form data object and appends every object in the product to it
             *  @return FormData
             */
            appendFormData() {
                let self = this;
                let form = new FormData();
                Object.keys(self.product).forEach(function(key) {
                    let keyString = String(key);
                    if(keyString === 'image' || keyString === 'upload' || keyString === 'thumbnail') {
                        if(keyString === 'upload' && self.showUpload) {
                            form.append(key, self.product[key]);
                        }
                        if((keyString === 'image' || keyString === 'thumbnail') && !self.showUpload) {
                            form.append(key, self.product[key]);
                        }
                        return;
                    }
                    form.append(key, self.product[key]);
                });
                return form;
            },

            /**
             * updates the user message and closes the modal
             * @param message
             * @return void
             */
            updateMessage(message) {
                Event.$emit('update-user-message', message);
                this.reset();
                this.cancel();
            },

            /**
             * updates a user error
             * @return void
             */
            updateError(){
                Event.$emit('update-user-error', 'An error has occurred please try again!');
                this.cancel();
            }
        }
    }
</script>

<style scoped>
    .uploaded-image {
        height: 100px;
        width: auto;
    }
</style>