# hf_product

Wordpress plugin that create a CPT "hf_product"

"hf_product" CPT has two associated taxonomies: "category" and "material". 

The CPT has an archive page that include a "filter by taxonomy terms" feature, with each taxonomy filter dropdown option featuring an "all" option.
The filter options should dynamically update according to the filters already selected via AJAX. However, terms that yield empty results after the initial filter is selected should not be shown in the dropdown options.

For example, if a term from the "category" taxonomy is selected, which fetches 3 entries of matching results, and among these 3 matching entries, none of them are linked with any terms with the material taxonomy, then none of the terms from "material" should be disabled upon the first initial filter (since selecting them will yield empty result).

The goal is to provide the best user experience possible, without preventing users from seeing an empty result.

Each option in the filter should have a numerical indicator next to it, displaying the number of results that would appear if it were selected. For example, if selecting Term A produces 3 results, there should be a numerical indicator next to it: "Term A (3)."

By default, if no filter has been applied, the archive page should display all post entries linked with the hf_product CPT.

The result should be reflected on the same page using the same archive page template.

The counter for terms of other taxonomies should be updated every time a new filter term is selected.
