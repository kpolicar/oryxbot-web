module.exports = {
    future: {
        // removeDeprecatedGapUtilities: true,
        // purgeLayersByDefault: true,
        // defaultLineHeights: true,
        // standardFontWeights: true
    },
    purge: [],
    variants: {
        display: ['responsive', 'group-hover', 'group-focus'],
        translate: ['responsive', 'hover', 'focus', 'group-hover'],
        textDecoration: ['responsive', 'group-hover', 'focus-within', 'hover', 'focus'],
    },
    plugins: [
        require("@tailwindcss/custom-forms")
    ]
}
