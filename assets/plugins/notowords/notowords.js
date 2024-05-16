function getBelowHundred(e){return teens[e]}function translate_nepali_num_into_words(e){if(isNaN(e)||""==e)return"N/A"
var t="",r=0
if(-1!=e.indexOf(".")&&(number_parts=e.split("."),e=number_parts[0],r=number_parts[1],decimal_tens=""+r.substring(0,2),1==decimal_tens.length&&(decimal_tens=""+decimal_tens+"0"),decimal_words=""+teens[parseInt(decimal_tens)]+" à¤ªà¥ˆà¤¸à¤¾"),e.length>13)return void alert("Number greater than kharab not supported")
var n=Math.floor(e%100)
if((""+e).length>2)var a=(""+e).substring((""+e).length-3,(""+e).length-2)
var i=Math.floor(e%1e5)
i=""+i,i=i.substring(0,i.length-3)
var o=Math.floor(e%1e7)
o=""+o,o=o.substring(0,o.length-5)
var s=Math.floor(e%1e9)
s=""+s,s=s.substring(0,s.length-7)
var l=Math.floor(e%1e11)
l=""+l,l=l.substring(0,l.length-9)
var u=Math.floor(e%1e13)
return u=""+u,u=u.substring(0,u.length-11),u>0&&(t+=teens[u]+" à¤–à¤°à¤¬"),l>0&&(t+=" "+teens[l]+" à¤…à¤°à¤¬"),s>0&&(t+=" "+teens[s]+" à¤•à¤°à¥‹à¤¡"),o>0&&(t+=" "+teens[o]+" à¤²à¤¾à¤–"),i>0&&(t+=" "+teens[i]+" à¤¹à¤œà¤¾à¤°"),a>0&&(t+=" "+units[a]+" à¤¸à¤¯"),n>0&&(t+=" "+teens[n]),""!=t.trim()&&(t+=" à¤°à¥à¤ªà¥ˆà¤‚à¤¯à¤¾"),r>0&&(t+=(""!=t.trim()?", ":"")+decimal_words),t}function get_nepali_currency(e){if(isNaN(e)||""==e)return"N/A"
if((""+Math.floor(e)).length>13)return"Too Long"
for(var t=Math.round(100*(e-Math.floor(e))),r=null,n=(""+e).length,a=["","Hundred","Thousand","Lakh","Crore","Arab","Kharab"],i={0:"",1:"One",2:"Two",3:"Three",4:"Four",5:"Five",6:"Six",7:"Seven",8:"Eight",9:"Nine",10:"Ten",11:"Eleven",12:"Twelve",13:"Thirteen",14:"Fourteen",15:"Fifteen",16:"Sixteen",17:"Seventeen",18:"Eighteen",19:"Nineteen",20:"Twenty",30:"Thirty",40:"Forty",50:"Fifty",60:"Sixty",70:"Seventy",80:"Eighty",90:"Ninety"},o=0,s=[],l=Math.floor(e);n>o;)divider=2==o?10:100,e=Math.floor(l%divider),l=Math.floor(l/divider),o+=10==divider?1:2,e?(plural=(counter=s.length)&&e>9?"s":"",r=1==counter&&s[0]?"and ":"",s.push(21>e?i[e]+" "+a[counter]+(2!=counter?plural:"")+" "+r:i[10*Math.floor(e/10)]+" "+i[e%10]+" "+a[counter]+(2!=counter?plural:"")+" "+r)):s.push("")
var u=s.reverse().join("").trim(),h=t?(u?"and ":"")+(21>t?i[t]:i[10*Math.floor(t/10)]+(t%10?" ":"")+i[t%10])+" Paisa":""
return(u?u+" Rupees ":"")+h}var units=["à¤¸à¥à¤¨à¥à¤¯","à¤à¤•","à¤¦à¥à¤ˆ","à¤¤à¥€à¤¨","à¤šà¤¾à¤°","à¤ªà¤¾à¤à¤š","à¤›","à¤¸à¤¾à¤¤","à¤†à¤ ","à¤¨à¥Œ","à¤¦à¤¸"],teens=["à¤¸à¥à¤¨à¥à¤¯","à¤à¤•","à¤¦à¥à¤ˆ","à¤¤à¥€à¤¨","à¤šà¤¾à¤°","à¤ªà¤¾à¤à¤š","à¤›","à¤¸à¤¾à¤¤","à¤†à¤ ","à¤¨à¥Œ","à¤¦à¤¸","à¤à¤˜à¤¾à¤°","à¤¬à¤¾à¤¹à¥à¤°","à¤¤à¥‡à¤¹à¥à¤°","à¤šà¥Œà¤§","à¤ªà¤¨à¥à¤§à¥à¤°","à¤¸à¥‹à¤¹à¥à¤°","à¤¸à¤¤à¥à¤°","à¤…à¤ à¤¾à¤¹à¥à¤°","à¤‰à¤¨à¥à¤¨à¤¾à¤‡à¤¸","à¤¬à¥€à¤¸","à¤à¤•à¤¾à¤‡à¤¸","à¤¬à¤¾à¤‡à¤¸","à¤¤à¥‡à¤‡à¤¸","à¤šà¥Œà¤¬à¥€à¤¸","à¤ªà¤šà¥€à¤¸","à¤›à¤¬à¥à¤¬à¥€à¤¸","à¤¸à¤¤à¥à¤¤à¤¾à¤‡à¤¸","à¤…à¤ à¥à¤ à¤¾à¤‡à¤¸","à¤‰à¤¨à¤¨à¥à¤¤à¥€à¤¸","à¤¤à¥€à¤¸","à¤à¤•à¤¤à¥€à¤¸","à¤¬à¤¤à¥€à¤¸","à¤¤à¥‡à¤¤à¥€à¤¸","à¤šà¥Œà¤¤à¥€à¤¸","à¤ªà¥ˆà¤¤à¥€à¤¸","à¤›à¤¤à¥€à¤¸","à¤¸à¤°à¤¤à¥€à¤¸","à¤…à¤°à¤¤à¥€à¤¸","à¤‰à¤¨à¤¨à¤šà¤¾à¤²à¥€à¤¸","à¤šà¤¾à¤²à¥€à¤¸","à¤à¤•à¤šà¤¾à¤²à¥€à¤¸","à¤¬à¤¯à¤¾à¤²à¤¿à¤¸","à¤¤à¥€à¤°à¤šà¤¾à¤²à¥€à¤¸","à¤šà¥Œà¤µà¤¾à¤²à¤¿à¤¸","à¤ªà¥ˆà¤‚à¤¤à¤¾à¤²à¤¿à¤¸","à¤›à¤¯à¤¾à¤²à¤¿à¤¸","à¤¸à¤°à¤šà¤¾à¤²à¥€à¤¸","à¤…à¤°à¤šà¤¾à¤²à¥€à¤¸","à¤‰à¤¨à¤¨à¤šà¤¾à¤¸","à¤ªà¤šà¤¾à¤¸","à¤à¤•à¤¾à¤‰à¤¨à¥à¤¨","à¤¬à¤¾à¤‰à¤¨à¥à¤¨","à¤¤à¥à¤°à¤¿à¤ªà¤¨à¥à¤¨","à¤šà¥Œà¤µà¤¨à¥à¤¨","à¤ªà¤šà¥à¤ªà¤¨à¥à¤¨","à¤›à¤ªà¤¨à¥à¤¨","à¤¸à¤¨à¥à¤¤à¤¾à¤‰à¤¨à¥à¤¨","à¤…à¤¨à¥à¤ à¤¾à¤‰à¤à¤¨à¥à¤¨","à¤‰à¤¨à¤¾à¤¨à¥à¤¨à¥à¤¸à¤¾à¤ à¥€ ","à¤¸à¤¾à¤ à¥€","à¤à¤•à¤¸à¤¾à¤ à¥€","à¤¬à¤¾à¤¸à¤¾à¤ à¥€","à¤¤à¥€à¤°à¤¸à¤¾à¤ à¥€","à¤šà¥Œà¤‚à¤¸à¤¾à¤ à¥€","à¤ªà¥ˆà¤¸à¤¾à¤ à¥€","à¤›à¥ˆà¤¸à¤ à¥€","à¤¸à¤¤à¥à¤¸à¤ à¥à¤ à¥€","à¤…à¤°à¥à¤¸à¤ à¥à¤ à¥€","à¤‰à¤¨à¤¨à¥à¤¸à¤¤à¥à¤¤à¤°à¥€","à¤¸à¤¤à¤°à¥€","à¤à¤•à¤¹à¤¤à¥à¤¤à¤°","à¤¬à¤¹à¤¤à¥à¤¤à¤°","à¤¤à¥à¤°à¤¿à¤¹à¤¤à¥à¤¤à¤°","à¤šà¥Œà¤¹à¤¤à¥à¤¤à¤°","à¤ªà¤šà¤¹à¤¤à¥à¤¤à¤°","à¤›à¤¹à¤¤à¥à¤¤à¤°","à¤¸à¤¤à¥à¤¹à¤¤à¥à¤¤à¤°","à¤…à¤ à¥à¤¹à¤¤à¥à¤¤à¤°","à¤‰à¤¨à¤¾à¤¸à¥à¤¸à¥€","à¤…à¤¸à¥à¤¸à¥€","à¤à¤•à¤¾à¤¸à¥€","à¤¬à¤¯à¤¾à¤¸à¥€","à¤¤à¥à¤°à¥€à¤¯à¤¾à¤¸à¥€","à¤šà¥Œà¤°à¤¾à¤¸à¥€","à¤ªà¤šà¤¾à¤¸à¥€","à¤›à¤¯à¤¾à¤¸à¥€","à¤¸à¤¤à¤¾à¤¸à¥€","à¤…à¤ à¤¾à¤¸à¥€","à¤‰à¤¨à¤¾à¤¨à¥à¤¨à¤¬à¥à¤¬à¥‡","à¤¨à¤¬à¥à¤¬à¥‡","à¤à¤•à¤¾à¤¨à¥à¤¨à¤¬à¥à¤¬à¥‡","à¤¬à¤¯à¤¾à¤¨à¥à¤¨à¤¬à¥à¤¬à¥‡","à¤¤à¥à¤°à¤¿à¤¯à¤¾à¤¨à¥à¤¨à¤¬à¥à¤¬à¥‡","à¤šà¥Œà¤°à¤¾à¤¨à¥à¤¨à¤¬à¥à¤¬à¥‡","à¤ªà¤‚à¤šà¤¾à¤¨à¥à¤¨à¤¬à¥à¤¬à¥‡","à¤›à¤¯à¤¾à¤¨à¥à¤¨à¤¬à¥à¤¬à¥‡","à¤¸à¤¨à¥à¤¤à¤¾à¤¨à¥â€à¤¨à¤¬à¥à¤¬à¥‡","à¤…à¤¨à¥à¤ à¤¾à¤¨à¥à¤¨à¤¬à¥à¤¬à¥‡","à¤‰à¤¨à¤¾à¤¨à¥à¤¸à¤¯"],tens=["","à¤¦à¤¸","à¤¬à¥€à¤¸","à¤¤à¥€à¤¸","à¤šà¤¾à¤²à¥€à¤¸","à¤ªà¤šà¤¾à¤¸","à¤¸à¤¾à¤ à¥€","à¤¸à¤¤à¤°à¥€","à¤…à¤¸à¥à¤¸à¥€","à¤¨à¤¬à¥à¤¬à¥‡"]