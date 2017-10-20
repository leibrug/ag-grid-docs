<?php
$key = "Tree Data";
$pageTitle = "ag-Grid Tree Data";
$pageDescription = "ag-Grid Tree Data";
$pageKeyboards = "ag-Grid Tree Data";
$pageGroup = "feature";
include '../documentation-main/documentation_header.php';
?>

<div>

    <h1 class="first-h1"><img src="../images/enterprise_50.png" title="Enterprise Feature"/> Tree Data</h1>

    <p>
        Tree Data contains pre-defined grouping and is typically preferred when data should be displayed at group levels.
    </p>

    </p>
        This section introduces simple ways to work with Tree Data before covering more advanced uses.
    </p>

    <h2 id="tree-data-mode">Tree Data Mode</h2>

    <p>
        In order to set the grid to work with Tree Data, simply enable Tree Data mode via the Grid Options using: <code>gridOptions.treeData = true</code>.
    </p>

    <h2 id="supplying-tree-data">Supplying Tree Data</h2>

    <p>
       When providing Tree Data to the grid it should be supplied as an array of objects in the same way as non grouped
       row data. However Tree Data differs in that it captures a path (or hierarchy) for each object. This is shown in
       the code snippet below:
    </p>
        <snippet>
var rowData = [
    {orgHierarchy: ['Erica'], jobTitle: "CEO", employmentType: "Permanent"},
    {orgHierarchy: ['Erica', 'Malcolm'], jobTitle: "VP", employmentType: "Permanent"}
    ...
]</snippet>

    <p>
        In the example above you will notice there is an object property (<code>orgHierarchy</code>) which represents a
        path for each entry. In this sample we see that 'Erica' is a parent of 'Malcolm'.
    </p>
    <p>
        There is nothing special about the property name (<code>orgHierarchy</code>)
        or the data type (<code>string[]</code>). For instance the same data could be represented as follows:
    </p>

    <snippet>
var rowData = [
    {path: "Erica", jobTitle: "CEO", employmentType: "Permanent"},
    {path: "Erica/Malcolm", jobTitle: "VP", employmentType: "Permanent"}
    ...
]</snippet>

    <p>
        All the grid requires is that you implement the <code>gridOptions.getDataPath(data)</code> callback and return a
        <code>string[]</code>. The following snippet demonstrates how this is done for both sample data formats above:
    </p>

    <snippet>
getDataPath: function(data) {
    return data.orgHierarchy; // orgHierarchy: ['Erica', 'Malcolm']
}

getDataPath: function(data) {
    return data.path.split('/'); // path: "Erica/Malcolm"
}
</snippet>

    <p>
        It is not necessary to include all levels in the path if data is not required at group levels. This is illustrated
        below:
    </p>

<snippet>
// all path levels provided
var rowData = [
    {filePath: ['Documents']},
    {filePath: ['Documents', 'txt']},
    {filePath: ['Documents', 'txt', 'notes.txt'], dateModified: "21 May 2017, 13:50", size: "14 KB"}
    ...
]

// only leaf level provided
var rowData = [
    {filePath: ['Documents', 'txt', 'notes.txt'], dateModified: "21 May 2017, 13:50", size: "14 KB"}
    ...
]</snippet>

    <p>
        In the second variation above the grid will create <i>filler nodes</i> for 'Documents' and 'txt'. However note
        that as these are generated by the grid they will not contain a <code>data</code> property on the <code>RowNode</code>.
    </p>

    <p>
        This could be a limitation if you wanted to provide an 'id' for each group node even when there is no data displayed at group levels.
    </p>

    <h2 id="specifying-a-group-column">Specifying a Group Column</h2>

    <p>
        Now that you have configured your path with the grid you will want to specify a group column for it. This should
        be done in the column definitions using <code>showRowGroup=true</code>. A simple group column using the provided
        'group' <code>cellRenderer</code> is shown below:
    </p>

<snippet>
{
    headerName: "Organisation Hierarchy",
    cellRenderer: 'group',
    showRowGroup: true
}</snippet>
    </p>

    <note>
        Only one column can be used for display groups, as no longer possible to assign a rowGroupColumn to the group display column.
        (what about AutoGroup column???)
    </note>

    <p>
        Refer to the section on <a href="../javascript-grid-grouping/#specifying-group-columns">Specifying Group Columns</a> for more details.
    </p>

    <p>
       The following example combines all the steps above to show a simplified organisational hierarchy:
    </p>

    <?= example('Org Hierarchy', 'org-hierarchy', 'generated', array("enterprise" => 1)) ?>


    <h2 id="tree-data-aggregation">Tree Data Aggregation</h2>

    <p>
        When using Tree Data, columns defined with an aggregation function will always perform aggregations on the group nodes.
        This means any supplied group data will be ignored in favour of the aggregated values.
    </p>
    <p>
        However if there are no child nodes to aggregate it will default to the provided value in the row data.
    </p>
    <p>
        The <a href="#example-file-browser">File Browser</a> example below demonstrates aggregation
        on the 'size' column.
    </p>
    <p>
        Also you can refer to the section on <a href="../javascript-grid-aggregation/">Aggregation</a> more details.
    </p>

    <h2 id="tree-data-filtering">Tree Data Filtering</h2>

    <p>
        The <a href="../javascript-grid-filter-set/">Set Filter</a> works differently when using Tree Data. By default
        it will display all unique values across each level of the group hierarchy when using Tree Data.
    </p>

    <p>
        Also note that as filtering is performed across all group levels, a group will be included if:
        <dl style="margin-left: 25px;">
            <dd>a) it has any children, or</dd>
            <dd>b) it's data passes the filter</dd>
        </dl>
    </p>

    <p>
        The <a href="#example-file-browser">File Browser</a> example below demonstrations filtering with Tree Data.
    </p>

    <?= example('File Browser', 'file-browser', 'generated', array('enterprise' => true, 'extras' => array('fontawesome')) ) ?>

</div>

<?php include '../documentation-main/documentation_footer.php';?>