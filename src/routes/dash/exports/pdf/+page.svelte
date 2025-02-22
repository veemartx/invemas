<script>
    // @ts-nocheck

    import { onMount } from "svelte";
	import { API_BASE_URL } from "$lib/config/base-urls";
	import { fetch_resource } from "$lib/methods/functions";
	import { add_commas, format_date } from "$lib/methods/methods";
	import { COMPANY } from "$lib/config/consts";
	import { generate_pdf } from "$lib/methods/pdf-make";
	
   

    const inventory_url=`${API_BASE_URL}reports/inventory.php`;


    let inventory = [];

    const column_titles= [
            { text: "No", bold: true, fontSize: 9 },
            { text: "Name", bold: true, fontSize: 9 },
            { text: "Code", bold: true, fontSize: 9 },
            { text: "Category (Subcategory)", bold: true, fontSize: 9 },
            { text: "Cost", bold: true, fontSize: 9 },
            { text: "Retail", bold: true, fontSize: 9 },
            { text: "Qty", bold: true, fontSize: 9 },
            { text: "Value", bold: true, fontSize: 9 },
            { text: "Created", bold: true, fontSize: 9 },
        ];

    const column_widths=[
            "6%",
            "20%",
            "9%",
            "25%",
            "8%",
            "8%",
            "7%",
            "9%",
            "10%",
        ]

    const make_rows=(products)=>{
        let rows=[];
        products.forEach((p,i)=>{
            rows.push([
                {
                    text: i + 1,
                    style: "reportValue",
                    fillColor: i%2==0?"#f7f0f0":"#f7f7f7",
                },

                {
                    text: p.name,
                    style: "reportValue",
                    fillColor: i%2==0?"#f7f0f0":"#f7f7f7",
                },

                {
                    text: p.code,
                    style: "reportValue",
                    fillColor: i%2==0?"#f7f0f0":"#f7f7f7",
                },

                {
                    text:`${p.category} (${p.subcategory})`,
                    style:"reportValue",
                    fillColor: i%2==0?"#f7f0f0":"#f7f7f7",
                },
        
                {
                    text: add_commas(parseFloat(p.cost_price)),
                    style: "reportValue",
                    fillColor: i%2==0?"#f7f0f0":"#f7f7f7",
                },
                {
                    text: add_commas(parseFloat(p.retail_price)),
                    style: "reportValue",
                    fillColor: i%2==0?"#f7f0f0":"#f7f7f7",
                },
                {
                    text: p.qty,
                    style: "reportValue",
                    fillColor: i%2==0?"#f7f0f0":"#f7f7f7",
                },
                {
                    text:  add_commas(parseFloat(p.qty*p.cost_price)),
                    style: "reportValue",
                    fillColor: i%2==0?"#f7f0f0":"#f7f7f7",
                },
                {
                    text: format_date(p.created_at,"YYYY-MM-DD"),
                    style: "reportValue",
                    fillColor: i%2==0?"#f7f0f0":"#f7f7f7",
                }
            ]);
        })

        return rows;
    }

  
    const get_inventory = async () => {

        const res=await fetch_resource("products",inventory_url);

        inventory=res.data;

        // console.log(inventory);

        //make rows
        let table_rows=make_rows(inventory);

        let documentNumber="INV200";

        let title="Products";

        let filters=[
            {
                name:"Low Stock",
                value:""
            },
            {
                name:"Addition Date",
                value:"2025-01-01 And 2025-02-13"
            }
        ]
        
        generate_pdf(title,documentNumber,filters,column_titles,column_widths,table_rows,COMPANY);

    };


 


    onMount(async() => {
        // inventory 
    //    await get_inventory();
    });
</script>

<main>
    <div id="iframeContainer" ></div>
    <div class="p-2">
        <button onclick={()=>{get_inventory()}} class="ui purple basic mini icon button">
           <i class="pdf file icon"></i> Export
        </button>
    </div>
</main>
