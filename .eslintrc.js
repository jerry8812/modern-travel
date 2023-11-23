module.exports = {
  extends: [
    'eslint:recommended',
    'plugin:vue/vue3-recommended'
  ],
  rules: {
    indent: ['warn', 2, { SwitchCase: 1 }],
    semi: [2, 'never'],
    'vue/html-indent': ['warn', 2, {
      attribute: 1,
      baseIndent: 1
    }],
    'import/extensions': ['off'],
    'vue/max-len': ['warn', {
      code: 200,
      ignoreHTMLAttributeValues: true,
      ignoreComments: true,
      ignoreTrailingComments: true
    }],
    'vue/no-v-html': ['off'],
    'vue/multi-word-component-names': ['off'],

    // other rules
    'array-bracket-spacing': ['warn', 'never'],
    'arrow-body-style': ['warn', 'as-needed'],
    'arrow-spacing': ['warn'],
    'block-spacing': ['warn', 'always'],
    'brace-style': ['warn', '1tbs', { allowSingleLine: true }],
    camelcase: ['warn', { properties: 'never' }],
    'comma-dangle': ['warn', 'never'],
    'comma-spacing': ['warn'],
    'computed-property-spacing': ['warn', 'never'],
    'eol-last': ['warn'],
    'func-call-spacing': ['warn', 'never'],
    'function-call-argument-newline': ['warn', 'consistent'],
    'key-spacing': ['warn'],
    'keyword-spacing': ['warn', { before: true, after: true }],
    'max-params': ['warn', 5],
    'no-multi-spaces': ['warn'],
    'no-multiple-empty-lines': ['warn', { max: 1 }],
    'no-return-await': ['warn'],
    'no-trailing-spaces': ['warn'],
    'no-unneeded-ternary': ['warn'],
    'no-unreachable': ['warn'],
    'no-unused-vars': ['warn'],
    'no-var': ['warn'],
    'no-debugger': ['warn'],
    'no-console': ['off'],
    'no-whitespace-before-property': ['warn'],
    'object-curly-spacing': ['warn', 'always'],
    'object-shorthand': ['warn', 'always'],
    'prefer-arrow-callback': ['warn'],
    'prefer-rest-params': ['warn'],
    'prefer-spread': ['warn'],
    'prefer-template': ['warn'],
    'quote-props': ['warn', 'as-needed'],
    quotes: ['warn', 'single'],
    'require-await': ['warn'],
    'rest-spread-spacing': ['warn', 'never'],
    'space-before-blocks': ['warn', 'always'],
    'space-before-function-paren': ['warn', {
      anonymous: 'always',
      named: 'never',
      asyncArrow: 'always'
    }],
    'space-in-parens': ['warn', 'never'],
    'template-curly-spacing': ['warn', 'never'],

    // ESLint import plugin extras
    'import/exports-last': ['off'], // can't have this rule if using vuejs <script setup> syntax
    'import/first': ['off'], // same as above, see resources/js/Pages/Projects/Share.vue for example
    'import/newline-after-import': ['warn', { count: 1 }],
    'import/no-duplicates': ['warn'],

    // ESLint vue plugin extras
    'vue/no-mutating-props': ['off'],
    'vue/new-line-between-multi-line-property': ['warn'],
    'vue/no-empty-component-block': ['warn'],
    'vue/no-useless-mustaches': ['warn'],
    'vue/no-useless-v-bind': ['warn'],
    'vue/no-boolean-default': ['warn'],
    'vue/require-default-prop': ['off'],
    'vue/html-self-closing': ['warn'],
    'vue/require-direct-export': ['warn'],
    'vue/no-extra-parens': ['warn'],
    'vue/no-unused-vars': ['warn'],
    'vue/padding-line-between-blocks': ['warn', 'always'],
    'vue/html-button-has-type': ['warn'],
    'vue/v-on-function-call': ['warn'],
    'vue/v-on-event-hyphenation': ['warn', 'always'],
    'vue/component-name-in-template-casing': ['off'], // consistent with all html tags,
    'vue/custom-event-name-casing': ['warn', 'kebab-case'],
    'vue/max-attributes-per-line': ['warn', {
      singleline: 4,
      multiline: 1
    }],
    'vue/block-tag-newline': ['warn', {
      singleline: 'always',
      multiline: 'always',
      maxEmptyLines: 0
    }]
  },
  plugins: [
    'vue',
    'import'
  ],
  parser: 'vue-eslint-parser',
  env: {
    browser: true,
    es6: true
  },
  globals: {
    module: true,
    globals: true,
    Ziggy: true,
    require: true,
    process: true,
    Toast: true,

    axios: true,
    route: true, // ziggy
    _: true, // lodash
    defineProps: true, // vue 3 setup function
    Vue: true
  }
}

