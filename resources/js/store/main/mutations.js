export default {
    SET_PP: (state, payload) => { state.pp = payload },
    SET_TABLE: (state, payload) => { state.table = payload },
    SET_HEADER: (state, payload) => { state.header = payload },
    SET_SUB_HEADER: (state, payload) => { state.subheader = payload },
    SET_CHANNEL: (state, payload) => { state.channel = payload },
    SET_PAGE: (state, payload) => { state.page = payload },
    SET_TITLES: (state, payload) => { state.titles = payload },
    SET_TITLE: (state, payload) => { state.title = payload },
    SET_MEDIA: (state, payload) => { state.media = payload },
    SET_CATEGORIES: (state, payload) => { state.categories = payload },
    SET_KEYWORDS: (state, payload) => { state.keywords = payload },
}
