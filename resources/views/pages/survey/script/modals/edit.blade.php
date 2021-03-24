<div class="modal fade" id="EditSurvey" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" data-backdrop="static" data-keyboard="false" aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width:900px;">
        <div class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Düzenle</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <input type="hidden" id="id_edit">
                    <div class="col-xl-3">
                        <div class="form-group">
                            <label for="code_edit">Kodu</label>
                            <input type="text" id="code_edit" class="form-control">
                        </div>
                    </div>
                    <div class="col-xl-9">
                        <div class="form-group">
                            <label for="name_edit">Adı</label>
                            <input type="text" id="name_edit" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-12">
                        <div class="form-group">
                            <label for="service_or_product_edit">Hizmet / Ürün</label>
                            <input type="text" id="service_or_product_edit" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-12">
                        <div class="form-group">
                            <label for="call_reason_edit">Çağrı Nedeni</label>
                            <input type="text" id="call_reason_edit" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-12">
                        <div class="form-group">
                            <label for="description_edit">Açıklama</label>
                            <textarea id="description_edit" class="form-control" rows="4"></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-6">
                        <div class="form-group">
                            <label for="customer_information_1_edit">Müşteri Bilgilendirmesi 1</label>
                            <textarea id="customer_information_1_edit" class="form-control" rows="4"></textarea>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="form-group">
                            <label for="customer_information_2_edit">Müşteri Bilgilendirmesi 2</label>
                            <textarea id="customer_information_2_edit" class="form-control" rows="4"></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="ays-col-5">
                        <div class="form-group">
                            <label for="opportunity_edit">Fırsat</label>
                            <select id="opportunity_edit" class="form-control">
                                <option value="0">Hayır</option>
                                <option value="1">Evet</option>
                            </select>
                        </div>
                    </div>
                    <div class="ays-col-5">
                        <div class="form-group">
                            <label for="call_edit">Çağrı</label>
                            <select id="call_edit" class="form-control">
                                <option value="0">Hayır</option>
                                <option value="1">Evet</option>
                            </select>
                        </div>
                    </div>
                    <div class="ays-col-5">
                        <div class="form-group">
                            <label for="dial_plan_edit">Arama Planı</label>
                            <select id="dial_plan_edit" class="form-control">
                                <option value="0">Hayır</option>
                                <option value="1">Evet</option>
                            </select>
                        </div>
                    </div>
                    <div class="ays-col-5">
                        <div class="form-group">
                            <label for="opportunity_redirect_to_seller_edit">Fırsat Satıcıya Yönlendir</label>
                            <select id="opportunity_redirect_to_seller_edit" class="form-control">
                                <option value="0">Hayır</option>
                                <option value="1">Evet</option>
                            </select>
                        </div>
                    </div>
                    <div class="ays-col-5">
                        <div class="form-group">
                            <label for="dial_plan_redirect_to_seller_edit">Arama Planı Satıcıya Yönlendir</label>
                            <select id="dial_plan_redirect_to_seller_edit" class="form-control">
                                <option value="0">Hayır</option>
                                <option value="1">Evet</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="updateSurveyButton">Güncelle</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Vazgeç</button>
            </div>
        </div>
    </div>
</div>
