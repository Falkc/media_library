param g;

param njeux;

param qttjeux {i in 1..njeux};

param v {i in 1..g, j in 1..njeux};

var x{i in 1..g,j in 1..njeux}, binary;


s.t. un_seul_jeu {j in 1..njeux}: sum {i in 1..g} x[i,j] <= qttjeux[j];







s.t. c10 : x[1,4] == 1;
s.t. c11 : x[1,7] == 1;
s.t. c12 : x[1,15] == 1;
maximize f: sum {i in 1..g, j in 1..njeux} (x[i,j]*v[i,j]);




printf "---Resutat---\n";

solve;

printf "---Fin---\n";
for {i in 1..g} {
	for {j in 1..njeux} {
		printf " %2d %2d    ",v[i,j],x[i,j];
	}
	printf "\n";
}

for {i in 1..g} {
	for {j in 1..njeux} {
		printf "@%d",x[i,j];
	}
}
printf "@";
end;